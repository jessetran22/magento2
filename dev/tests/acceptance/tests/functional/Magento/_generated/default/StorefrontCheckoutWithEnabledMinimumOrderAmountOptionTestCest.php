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
 * @Title("[NO TESTCASEID]: Minimum Order Amount Option Enabled for Checkout")
 * @Description("Customer should not be able to place an order with if minimum order amount was not reached<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckoutWithEnabledMinimumOrderAmountOptionTest.xml<br>")
 * @group checkout
 */
class StorefrontCheckoutWithEnabledMinimumOrderAmountOptionTestCest
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
		$enableMinimumOrderAmount = $I->magentoCLI("config:set sales/minimum_order/active 1", 60); // stepKey: enableMinimumOrderAmount
		$I->comment($enableMinimumOrderAmount);
		$setMinimumOrderAmount100 = $I->magentoCLI("config:set sales/minimum_order/amount 100", 60); // stepKey: setMinimumOrderAmount100
		$I->comment($setMinimumOrderAmount100);
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct50", ["createCategory"], []); // stepKey: createProduct
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
		$disableMinimumOrderAmount = $I->magentoCLI("config:set sales/minimum_order/active 0", 60); // stepKey: disableMinimumOrderAmount
		$I->comment($disableMinimumOrderAmount);
		$setMinimumOrderAmountDefaultValue = $I->magentoCLI("config:set sales/minimum_order/amount 0", 60); // stepKey: setMinimumOrderAmountDefaultValue
		$I->comment($setMinimumOrderAmountDefaultValue);
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Features({"Checkout"})
	 * @Stories({"Order Placement With Enabled Minimum Order Amount Option"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckoutWithEnabledMinimumOrderAmountOptionTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [navigateToCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageNavigateToCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedNavigateToCartPage
		$I->comment("Exiting Action Group [navigateToCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [assertMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->see("Minimum order amount is $100.00", "#maincontent .message-notice"); // stepKey: verifyMessageAssertMessage
		$I->comment("Exiting Action Group [assertMessage] AssertMessageCustomerChangeAccountInfoActionGroup");
		$I->comment("Entering Action Group [assertCheckoutBtnDisabled] AssertStorefrontProceedToCheckoutButtonDisabledActionGroup");
		$I->seeElement(".action.primary.checkout.disabled"); // stepKey: assertCheckoutBtnDisabledAssertCheckoutBtnDisabled
		$I->waitForPageLoad(60); // stepKey: assertCheckoutBtnDisabledAssertCheckoutBtnDisabledWaitForPageLoad
		$I->comment("Exiting Action Group [assertCheckoutBtnDisabled] AssertStorefrontProceedToCheckoutButtonDisabledActionGroup");
		$I->comment("Entering Action Group [navigateToProductPage] OpenProductFromCategoryPageActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_path]', 'test') . ".html"); // stepKey: navigateToCategoryPageNavigateToProductPage
		$I->comment("Go to storefront product page");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]"); // stepKey: openProductPageNavigateToProductPage
		$I->waitForAjaxLoad(30); // stepKey: waitForImageLoaderNavigateToProductPage
		$I->comment("Exiting Action Group [navigateToProductPage] OpenProductFromCategoryPageActionGroup");
		$I->comment("Entering Action Group [addSecondProductToTheCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAddSecondProductToTheCart
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProduct1QuantityAddSecondProductToTheCart
		$I->waitForPageLoad(30); // stepKey: fillProduct1QuantityAddSecondProductToTheCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddSecondProductToTheCart
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonAddSecondProductToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddSecondProductToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddSecondProductToTheCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageAddSecondProductToTheCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageAddSecondProductToTheCartWaitForPageLoad
		$I->comment("Exiting Action Group [addSecondProductToTheCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->comment("Entering Action Group [openShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenShoppingCartPage
		$I->comment("Exiting Action Group [openShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [goToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutGoToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCheckout
		$I->comment("Exiting Action Group [goToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Entering Action Group [selectFlatRate] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->conditionalClick("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", true); // stepKey: selectFlatRateShippingMethodSelectFlatRate
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRate
		$I->comment("Exiting Action Group [selectFlatRate] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->comment("Entering Action Group [goToReview] StorefrontCheckoutForwardFromShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToReview
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToReviewWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToReview
		$I->waitForPageLoad(30); // stepKey: clickNextGoToReviewWaitForPageLoad
		$I->comment("Exiting Action Group [goToReview] StorefrontCheckoutForwardFromShippingStepActionGroup");
		$I->comment("Entering Action Group [selectCheckMoneyOrder] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyOrder
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyOrder
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyOrder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyOrder
		$I->comment("Exiting Action Group [selectCheckMoneyOrder] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [clickOnPlaceOrder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickOnPlaceOrderWaitForPageLoad
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeOrderNumberClickOnPlaceOrder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouClickOnPlaceOrder
		$I->comment("Exiting Action Group [clickOnPlaceOrder] CheckoutPlaceOrderActionGroup");
	}
}
