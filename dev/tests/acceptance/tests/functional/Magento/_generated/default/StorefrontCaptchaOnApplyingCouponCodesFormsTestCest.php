<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("[NO TESTCASEID]: Captcha on applying coupon code forms")
 * @Description("Customer should be able apply coupon codes with enabled captcha<h3>Test files</h3>app/code/Magento/Captcha/Test/Mftf/Test/StorefrontCaptchaOnApplyingCouponCodesFormsTest.xml<br>")
 * @group captcha
 */
class StorefrontCaptchaOnApplyingCouponCodesFormsTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->createEntity("createCartPriceRule", "hook", "SalesRuleSpecificCouponWithFixedDiscount", [], []); // stepKey: createCartPriceRule
		$I->createEntity("createCouponForCartPriceRule", "hook", "SimpleSalesRuleCoupon", ["createCartPriceRule"], []); // stepKey: createCouponForCartPriceRule
		$enableBankTransferPayment = $I->magentoCLI("config:set payment/banktransfer/active 1", 60); // stepKey: enableBankTransferPayment
		$I->comment($enableBankTransferPayment);
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
		$setCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 3", 60); // stepKey: setCaptchaLength
		$I->comment($setCaptchaLength);
		$setCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols 1", 60); // stepKey: setCaptchaSymbols
		$I->comment($setCaptchaSymbols);
		$enableCaptchaOnApplyingCouponsForms = $I->magentoCLI("config:set customer/captcha/forms sales_rule_coupon_request", 60); // stepKey: enableCaptchaOnApplyingCouponsForms
		$I->comment($enableCaptchaOnApplyingCouponsForms);
		$setCaptchaAlwaysVisible = $I->magentoCLI("config:set customer/captcha/mode always", 60); // stepKey: setCaptchaAlwaysVisible
		$I->comment($setCaptchaAlwaysVisible);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCartPriceRule", "hook"); // stepKey: deleteCartPriceRule
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$disableBankTransferPayment = $I->magentoCLI("config:set payment/banktransfer/active 0", 60); // stepKey: disableBankTransferPayment
		$I->comment($disableBankTransferPayment);
		$setDefaultCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 4-5", 60); // stepKey: setDefaultCaptchaLength
		$I->comment($setDefaultCaptchaLength);
		$setDefaultCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols ABCDEFGHJKMnpqrstuvwxyz23456789", 60); // stepKey: setDefaultCaptchaSymbols
		$I->comment($setDefaultCaptchaSymbols);
		$setCaptchaDefaultVisibility = $I->magentoCLI("config:set customer/captcha/mode after_fail", 60); // stepKey: setCaptchaDefaultVisibility
		$I->comment($setCaptchaDefaultVisibility);
		$enableCaptchaOnDefaultForms = $I->magentoCLI("config:set customer/captcha/forms user_login,user_forgotpassword", 60); // stepKey: enableCaptchaOnDefaultForms
		$I->comment($enableCaptchaOnDefaultForms);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Captcha"})
	 * @Stories({"Applying coupon codes with enabled captcha"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCaptchaOnApplyingCouponCodesFormsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccount
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccount
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccount
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccount
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccount
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccount
		$I->comment("Exiting Action Group [loginToStorefrontAccount] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [openProductFromCategory] OpenProductFromCategoryPageActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_path]', 'test') . ".html"); // stepKey: navigateToCategoryPageOpenProductFromCategory
		$I->comment("Go to storefront product page");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]"); // stepKey: openProductPageOpenProductFromCategory
		$I->waitForAjaxLoad(30); // stepKey: waitForImageLoaderOpenProductFromCategory
		$I->comment("Exiting Action Group [openProductFromCategory] OpenProductFromCategoryPageActionGroup");
		$I->comment("Entering Action Group [addProductToTheCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAddProductToTheCart
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProduct1QuantityAddProductToTheCart
		$I->waitForPageLoad(30); // stepKey: fillProduct1QuantityAddProductToTheCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddProductToTheCart
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonAddProductToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddProductToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToTheCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageAddProductToTheCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageAddProductToTheCartWaitForPageLoad
		$I->comment("Exiting Action Group [addProductToTheCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->comment("Entering Action Group [navigateToShoppingCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageNavigateToShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedNavigateToShoppingCart
		$I->comment("Exiting Action Group [navigateToShoppingCart] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [assertCaptchaIsPresent] AssertStorefrontCaptchaVisibleOnShoppingCartApplyCouponCodeFormActionGroup");
		$I->waitForElement("#block-discount-heading", 30); // stepKey: waitForCouponHeaderAssertCaptchaIsPresent
		$I->conditionalClick("#block-discount-heading", ".block.discount.active", false); // stepKey: clickCouponHeaderAssertCaptchaIsPresent
		$I->waitForElementVisible("#coupon_code", 30); // stepKey: waitForCouponFieldAssertCaptchaIsPresent
		$I->waitForElementVisible("#discount-coupon-form input[name='captcha[sales_rule_coupon_request]']", 30); // stepKey: waitToSeeCaptchaFieldAssertCaptchaIsPresent
		$I->waitForElementVisible("#discount-coupon-form img.captcha-img", 30); // stepKey: waitToSeeCaptchaImageAssertCaptchaIsPresent
		$I->waitForElementVisible("#discount-coupon-form button.captcha-reload", 30); // stepKey: waitToSeeCaptchaReloadButtonAssertCaptchaIsPresent
		$I->reloadPage(); // stepKey: refreshPageAssertCaptchaIsPresent
		$I->waitForPageLoad(30); // stepKey: waitForPageReloadedAssertCaptchaIsPresent
		$I->waitForElement("#block-discount-heading", 30); // stepKey: waitForCouponHeaderAfterReloadAssertCaptchaIsPresent
		$I->conditionalClick("#block-discount-heading", ".block.discount.active", false); // stepKey: clickCouponHeaderAfterReloadAssertCaptchaIsPresent
		$I->waitForElementVisible("#coupon_code", 30); // stepKey: waitForCouponFieldAfterReloadAssertCaptchaIsPresent
		$I->waitForElementVisible("#discount-coupon-form input[name='captcha[sales_rule_coupon_request]']", 30); // stepKey: waitToSeeCaptchaFieldAfterPageReloadAssertCaptchaIsPresent
		$I->waitForElementVisible("#discount-coupon-form img.captcha-img", 30); // stepKey: waitToSeeCaptchaImageAfterPageReloadAssertCaptchaIsPresent
		$I->waitForElementVisible("#discount-coupon-form button.captcha-reload", 30); // stepKey: waitToSeeCaptchaReloadButtonAfterPageReloadAssertCaptchaIsPresent
		$I->comment("Exiting Action Group [assertCaptchaIsPresent] AssertStorefrontCaptchaVisibleOnShoppingCartApplyCouponCodeFormActionGroup");
		$I->comment("Entering Action Group [fillDiscountField] StorefrontShoppingCartFillCouponCodeFieldActionGroup");
		$I->conditionalClick("//*[text()='Apply Discount Code']", "#coupon_code", false); // stepKey: clickToAddDiscountFillDiscountField
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFillDiscountField
		$I->fillField("#coupon_code", $I->retrieveEntityField('createCouponForCartPriceRule', 'code', 'test')); // stepKey: fillFieldDiscountCodeFillDiscountField
		$I->comment("Exiting Action Group [fillDiscountField] StorefrontShoppingCartFillCouponCodeFieldActionGroup");
		$I->comment("Entering Action Group [fillCaptchaWithIncorrectValues] StorefrontShoppingCartFillCaptchaFieldOnApplyDiscountFormActionGroup");
		$I->fillField("#discount-coupon-form input[name='captcha[sales_rule_coupon_request]']", "WrongCAPTCHA" . msq("WrongCaptcha")); // stepKey: fillCaptchaFieldFillCaptchaWithIncorrectValues
		$I->comment("Exiting Action Group [fillCaptchaWithIncorrectValues] StorefrontShoppingCartFillCaptchaFieldOnApplyDiscountFormActionGroup");
		$I->comment("Entering Action Group [clickApplyButton] StorefrontShoppingCartClickApplyDiscountButtonActionGroup");
		$I->conditionalClick("//*[text()='Apply Discount Code']", "#coupon_code", false); // stepKey: clickToAddDiscountClickApplyButton
		$I->click("//span[text()='Apply Discount']"); // stepKey: clickToApplyDiscountClickApplyButton
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickApplyButton
		$I->comment("Exiting Action Group [clickApplyButton] StorefrontShoppingCartClickApplyDiscountButtonActionGroup");
		$I->comment("Entering Action Group [assertErrorMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("Incorrect CAPTCHA", "#maincontent .message-error"); // stepKey: verifyMessageAssertErrorMessage
		$I->comment("Exiting Action Group [assertErrorMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->comment("Entering Action Group [fillDiscountCodeField] StorefrontShoppingCartFillCouponCodeFieldActionGroup");
		$I->conditionalClick("//*[text()='Apply Discount Code']", "#coupon_code", false); // stepKey: clickToAddDiscountFillDiscountCodeField
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFillDiscountCodeField
		$I->fillField("#coupon_code", $I->retrieveEntityField('createCouponForCartPriceRule', 'code', 'test')); // stepKey: fillFieldDiscountCodeFillDiscountCodeField
		$I->comment("Exiting Action Group [fillDiscountCodeField] StorefrontShoppingCartFillCouponCodeFieldActionGroup");
		$I->comment("Entering Action Group [fillCaptchaWithCorrectValues] StorefrontShoppingCartFillCaptchaFieldOnApplyDiscountFormActionGroup");
		$I->fillField("#discount-coupon-form input[name='captcha[sales_rule_coupon_request]']", "111"); // stepKey: fillCaptchaFieldFillCaptchaWithCorrectValues
		$I->comment("Exiting Action Group [fillCaptchaWithCorrectValues] StorefrontShoppingCartFillCaptchaFieldOnApplyDiscountFormActionGroup");
		$I->comment("Entering Action Group [clickApplyDiscountButton] StorefrontShoppingCartClickApplyDiscountButtonActionGroup");
		$I->conditionalClick("//*[text()='Apply Discount Code']", "#coupon_code", false); // stepKey: clickToAddDiscountClickApplyDiscountButton
		$I->click("//span[text()='Apply Discount']"); // stepKey: clickToApplyDiscountClickApplyDiscountButton
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickApplyDiscountButton
		$I->comment("Exiting Action Group [clickApplyDiscountButton] StorefrontShoppingCartClickApplyDiscountButtonActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("You used coupon code \"" . $I->retrieveEntityField('createCouponForCartPriceRule', 'code', 'test') . "\".", "#maincontent .message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
	}
}
