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
 * @Title("MC-38271: SalesRule Discount Is Applied On PackageValue For TableRate")
 * @Description("SalesRule Discount Is Applied On PackageValue For TableRate<h3>Test files</h3>app/code/Magento/OfflineShipping/Test/Mftf/Test/SalesRuleDiscountIsAppliedOnPackageValueForTableRateTest.xml<br>")
 * @TestCaseId("MC-38271")
 * @group shipping
 */
class SalesRuleDiscountIsAppliedOnPackageValueForTableRateTestCest
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
		$I->comment("Add simple product");
		$createSimpleProductFields['price'] = "13.00";
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], $createSimpleProductFields); // stepKey: createSimpleProduct
		$I->comment("Create cart price rule");
		$I->createEntity("createCartPriceRule", "hook", "ActiveSalesRuleForNotLoggedIn", [], []); // stepKey: createCartPriceRule
		$I->createEntity("createCouponForCartPriceRule", "hook", "SimpleSalesRuleCoupon", ["createCartPriceRule"], []); // stepKey: createCouponForCartPriceRule
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Go to Stores > Configuration > Sales > Shipping Methods");
		$I->comment("Entering Action Group [openShippingMethodConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/carriers/"); // stepKey: navigateToAdminShippingMethodsPageOpenShippingMethodConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForAdminShippingMethodsPageToLoadOpenShippingMethodConfigPage
		$I->comment("Exiting Action Group [openShippingMethodConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->comment("Switch to Website scope");
		$I->comment("Entering Action Group [AdminSwitchStoreView] AdminSwitchWebsiteActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopAdminSwitchStoreView
		$I->click("#store-change-button"); // stepKey: clickWebsiteSwitchDropdownAdminSwitchStoreView
		$I->waitForElementVisible("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]", 30); // stepKey: waitForWebsiteAreVisibleAdminSwitchStoreView
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteAreVisibleAdminSwitchStoreViewWaitForPageLoad
		$I->click("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]"); // stepKey: clickWebsiteByNameAdminSwitchStoreView
		$I->waitForPageLoad(30); // stepKey: clickWebsiteByNameAdminSwitchStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchStoreView
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchStoreViewWaitForPageLoad
		$I->see("Main Website", ".store-switcher"); // stepKey: seeNewWebsiteNameAdminSwitchStoreView
		$I->comment("Exiting Action Group [AdminSwitchStoreView] AdminSwitchWebsiteActionGroup");
		$I->comment("Enable Table Rate method and save config");
		$I->comment("Entering Action Group [enableTableRatesShippingMethod] AdminChangeTableRatesShippingMethodStatusActionGroup");
		$I->conditionalClick("#carriers_tablerate-head", "#carriers_tablerate_active", false); // stepKey: expandTabEnableTableRatesShippingMethod
		$I->uncheckOption("#carriers_tablerate_active_inherit"); // stepKey: uncheckUseSystemValueEnableTableRatesShippingMethod
		$I->selectOption("#carriers_tablerate_active", "1"); // stepKey: changeTableRatesMethodStatusEnableTableRatesShippingMethod
		$I->comment("Exiting Action Group [enableTableRatesShippingMethod] AdminChangeTableRatesShippingMethodStatusActionGroup");
		$I->comment("Uncheck Use Default checkbox for Default Condition");
		$I->uncheckOption("#carriers_tablerate_condition_name_inherit"); // stepKey: disableUseDefaultCondition
		$I->comment("Make sure you have Condition Price vs. Destination");
		$I->selectOption("#carriers_tablerate_condition_name", "Price vs. Destination"); // stepKey: setCondition
		$I->comment("Import file and save config");
		$I->attachFile("#carriers_tablerate_import", "usa_tablerates.csv"); // stepKey: attachFileForImport
		$I->comment("Entering Action Group [saveConfigs] AdminSaveConfigActionGroup");
		$I->click("#save"); // stepKey: clickSaveConfigBtnSaveConfigs
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveConfigs
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveConfigs
		$I->comment("Exiting Action Group [saveConfigs] AdminSaveConfigActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Go to Stores > Configuration > Sales > Shipping Methods");
		$I->comment("Entering Action Group [openShippingMethodConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/carriers/"); // stepKey: navigateToAdminShippingMethodsPageOpenShippingMethodConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForAdminShippingMethodsPageToLoadOpenShippingMethodConfigPage
		$I->comment("Exiting Action Group [openShippingMethodConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->comment("Switch to Website scope");
		$I->comment("Entering Action Group [AdminSwitchStoreView] AdminSwitchWebsiteActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopAdminSwitchStoreView
		$I->click("#store-change-button"); // stepKey: clickWebsiteSwitchDropdownAdminSwitchStoreView
		$I->waitForElementVisible("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]", 30); // stepKey: waitForWebsiteAreVisibleAdminSwitchStoreView
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteAreVisibleAdminSwitchStoreViewWaitForPageLoad
		$I->click("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]"); // stepKey: clickWebsiteByNameAdminSwitchStoreView
		$I->waitForPageLoad(30); // stepKey: clickWebsiteByNameAdminSwitchStoreViewWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchStoreView
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchStoreViewWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchStoreView
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchStoreViewWaitForPageLoad
		$I->see("Main Website", ".store-switcher"); // stepKey: seeNewWebsiteNameAdminSwitchStoreView
		$I->comment("Exiting Action Group [AdminSwitchStoreView] AdminSwitchWebsiteActionGroup");
		$I->comment("Check Use Default checkbox for Default Condition and Active");
		$I->checkOption("#carriers_tablerate_condition_name_inherit"); // stepKey: enableUseDefaultCondition
		$I->checkOption("#carriers_tablerate_active_inherit"); // stepKey: enableUseDefaultActive
		$I->comment("Entering Action Group [saveConfigs] AdminSaveConfigActionGroup");
		$I->click("#save"); // stepKey: clickSaveConfigBtnSaveConfigs
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveConfigs
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveConfigs
		$I->comment("Exiting Action Group [saveConfigs] AdminSaveConfigActionGroup");
		$I->comment("Log out");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Remove simple product");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Delete sales rule");
		$I->deleteEntity("createCartPriceRule", "hook"); // stepKey: deleteCartPriceRule
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
	 * @Features({"OfflineShipping"})
	 * @Stories({"Offline Shipping Methods"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function SalesRuleDiscountIsAppliedOnPackageValueForTableRateTest(AcceptanceTester $I)
	{
		$I->comment("Add simple product to cart");
		$I->comment("Entering Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Assert that table rate value is correct for US");
		$I->comment("Entering Action Group [goToCheckout] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCheckout
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCheckout
		$I->comment("Exiting Action Group [goToCheckout] StorefrontCartPageOpenActionGroup");
		$I->waitForElement("#shipping-zip-form", 30); // stepKey: waitForEstimateShippingAndTaxForm
		$I->waitForElement("#co-shipping-method-form", 30); // stepKey: waitForShippingMethodForm
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: expandEstimateShippingandTax
		$I->waitForPageLoad(10); // stepKey: expandEstimateShippingandTaxWaitForPageLoad
		$I->selectOption("select[name='country_id']", "United States"); // stepKey: selectUSCountry
		$I->waitForPageLoad(10); // stepKey: selectUSCountryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSelectCountry
		$I->see("$5.99", "#co-shipping-method-form span .price"); // stepKey: seeShippingForUS
		$I->comment("Apply Coupon");
		$I->comment("Entering Action Group [applyDiscount] StorefrontApplyCouponActionGroup");
		$I->waitForElement("#block-discount-heading", 30); // stepKey: waitForCouponHeaderApplyDiscount
		$I->conditionalClick("#block-discount-heading", ".block.discount.active", false); // stepKey: clickCouponHeaderApplyDiscount
		$I->waitForElementVisible("#coupon_code", 30); // stepKey: waitForCouponFieldApplyDiscount
		$I->fillField("#coupon_code", $I->retrieveEntityField('createCouponForCartPriceRule', 'code', 'test')); // stepKey: fillCouponFieldApplyDiscount
		$I->click("#discount-coupon-form button[class*='apply']"); // stepKey: clickApplyButtonApplyDiscount
		$I->waitForPageLoad(30); // stepKey: clickApplyButtonApplyDiscountWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadApplyDiscount
		$I->comment("Exiting Action Group [applyDiscount] StorefrontApplyCouponActionGroup");
		$I->see("$7.99", "#co-shipping-method-form span .price"); // stepKey: seeShippingForUSWithDiscount
	}
}
