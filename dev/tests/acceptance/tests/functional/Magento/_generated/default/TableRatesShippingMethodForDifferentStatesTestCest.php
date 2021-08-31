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
 * @Title("MC-13581: Table rates shipping method for different states test")
 * @Description("Checkout with Table Rates for different states of the USA<h3>Test files</h3>app/code/Magento/Shipping/Test/Mftf/Test/TableRatesShippingMethodForDifferentStatesTest.xml<br>")
 * @TestCaseId("MC-13581")
 * @group shipping
 */
class TableRatesShippingMethodForDifferentStatesTestCest
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
		$I->comment("Create product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_CA", [], []); // stepKey: createCustomer
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Log out");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"Shipping"})
	 * @Stories({"Table Rates"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function TableRatesShippingMethodForDifferentStatesTest(AcceptanceTester $I)
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
		$I->comment("Enable Table Rate method and save config");
		$I->comment("Entering Action Group [enableTableRatesShippingMethod] AdminChangeTableRatesShippingMethodStatusActionGroup");
		$I->conditionalClick("#carriers_tablerate-head", "#carriers_tablerate_active", false); // stepKey: expandTabEnableTableRatesShippingMethod
		$I->uncheckOption("#carriers_tablerate_active_inherit"); // stepKey: uncheckUseSystemValueEnableTableRatesShippingMethod
		$I->selectOption("#carriers_tablerate_active", "1"); // stepKey: changeTableRatesMethodStatusEnableTableRatesShippingMethod
		$I->comment("Exiting Action Group [enableTableRatesShippingMethod] AdminChangeTableRatesShippingMethodStatusActionGroup");
		$I->comment("Entering Action Group [saveConfig] AdminSaveConfigActionGroup");
		$I->click("#save"); // stepKey: clickSaveConfigBtnSaveConfig
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveConfig
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveConfig
		$I->comment("Exiting Action Group [saveConfig] AdminSaveConfigActionGroup");
		$I->comment("Make sure you have Condition Weight vs. Destination");
		$I->see("Weight vs. Destination", "#carriers_tablerate_condition_name"); // stepKey: seeDefaultCondition
		$I->comment("Import file and save config");
		$I->attachFile("#carriers_tablerate_import", "table_rate_30895.csv"); // stepKey: attachFileForImport
		$I->comment("Entering Action Group [saveConfigs] AdminSaveConfigActionGroup");
		$I->click("#save"); // stepKey: clickSaveConfigBtnSaveConfigs
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveConfigs
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveConfigs
		$I->comment("Exiting Action Group [saveConfigs] AdminSaveConfigActionGroup");
		$I->comment("Login as customer");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Add product to the shopping cart");
		$I->comment("Entering Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Open the shopping cart page");
		$I->comment("Entering Action Group [openShoppingCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenShoppingCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenShoppingCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenShoppingCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenShoppingCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenShoppingCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenShoppingCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenShoppingCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenShoppingCartWaitForPageLoad
		$I->comment("Exiting Action Group [openShoppingCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Expand Estimate Shipping and Tax section in Summary");
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: expandEstimateShippingAndTax
		$I->waitForPageLoad(10); // stepKey: expandEstimateShippingAndTaxWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask
		$I->comment("See available Table Rate option");
		$I->comment("Entering Action Group [assertShippingMethodLabel] StorefrontAssertShippingMethodPresentInCartActionGroup");
		$I->see("Best Way", "#co-shipping-method-form dl dt span"); // stepKey: assertShippingMethodIsPresentInCartAssertShippingMethodLabel
		$I->comment("Exiting Action Group [assertShippingMethodLabel] StorefrontAssertShippingMethodPresentInCartActionGroup");
		$I->comment("Entering Action Group [assertShippingMethodOption] StorefrontAssertShippingMethodOptionPresentInCartActionGroup");
		$I->see("Table Rate", "#co-shipping-method-form label"); // stepKey: seeShippingNameAssertShippingMethodOption
		$I->see("5.00", "#co-shipping-method-form span .price"); // stepKey: seeShippingPriceAssertShippingMethodOption
		$I->comment("Exiting Action Group [assertShippingMethodOption] StorefrontAssertShippingMethodOptionPresentInCartActionGroup");
		$I->comment("Change State to New York");
		$I->selectOption("select[name='region_id']", "New York"); // stepKey: selectAnotherState
		$I->waitForPageLoad(10); // stepKey: selectAnotherStateWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodLoad
		$I->comment("See available Table Rate option for another state");
		$I->comment("Entering Action Group [assertShippingMethodLabelForAnotherState] StorefrontAssertShippingMethodPresentInCartActionGroup");
		$I->see("Best Way", "#co-shipping-method-form dl dt span"); // stepKey: assertShippingMethodIsPresentInCartAssertShippingMethodLabelForAnotherState
		$I->comment("Exiting Action Group [assertShippingMethodLabelForAnotherState] StorefrontAssertShippingMethodPresentInCartActionGroup");
		$I->comment("Entering Action Group [assertShippingMethodOptionForAnotherState] StorefrontAssertShippingMethodOptionPresentInCartActionGroup");
		$I->see("Table Rate", "#co-shipping-method-form label"); // stepKey: seeShippingNameAssertShippingMethodOptionForAnotherState
		$I->see("10.00", "#co-shipping-method-form span .price"); // stepKey: seeShippingPriceAssertShippingMethodOptionForAnotherState
		$I->comment("Exiting Action Group [assertShippingMethodOptionForAnotherState] StorefrontAssertShippingMethodOptionPresentInCartActionGroup");
		$I->comment("Rollback config");
		$I->comment("Entering Action Group [openShippingMethodSystemConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/carriers/"); // stepKey: navigateToAdminShippingMethodsPageOpenShippingMethodSystemConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForAdminShippingMethodsPageToLoadOpenShippingMethodSystemConfigPage
		$I->comment("Exiting Action Group [openShippingMethodSystemConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->comment("Entering Action Group [AdminSwitchStoreViewToMainWebsite] AdminSwitchWebsiteActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopAdminSwitchStoreViewToMainWebsite
		$I->click("#store-change-button"); // stepKey: clickWebsiteSwitchDropdownAdminSwitchStoreViewToMainWebsite
		$I->waitForElementVisible("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]", 30); // stepKey: waitForWebsiteAreVisibleAdminSwitchStoreViewToMainWebsite
		$I->waitForPageLoad(30); // stepKey: waitForWebsiteAreVisibleAdminSwitchStoreViewToMainWebsiteWaitForPageLoad
		$I->click("//*[@class='store-switcher-website  ']/a[contains(text(), 'Main Website')]"); // stepKey: clickWebsiteByNameAdminSwitchStoreViewToMainWebsite
		$I->waitForPageLoad(30); // stepKey: clickWebsiteByNameAdminSwitchStoreViewToMainWebsiteWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitingForInformationModalAdminSwitchStoreViewToMainWebsite
		$I->waitForPageLoad(60); // stepKey: waitingForInformationModalAdminSwitchStoreViewToMainWebsiteWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmStoreSwitchAdminSwitchStoreViewToMainWebsite
		$I->waitForPageLoad(60); // stepKey: confirmStoreSwitchAdminSwitchStoreViewToMainWebsiteWaitForPageLoad
		$I->see("Main Website", ".store-switcher"); // stepKey: seeNewWebsiteNameAdminSwitchStoreViewToMainWebsite
		$I->comment("Exiting Action Group [AdminSwitchStoreViewToMainWebsite] AdminSwitchWebsiteActionGroup");
		$I->comment("Entering Action Group [disableTableRatesShippingMethod] AdminChangeTableRatesShippingMethodStatusActionGroup");
		$I->conditionalClick("#carriers_tablerate-head", "#carriers_tablerate_active", false); // stepKey: expandTabDisableTableRatesShippingMethod
		$I->uncheckOption("#carriers_tablerate_active_inherit"); // stepKey: uncheckUseSystemValueDisableTableRatesShippingMethod
		$I->selectOption("#carriers_tablerate_active", "0"); // stepKey: changeTableRatesMethodStatusDisableTableRatesShippingMethod
		$I->comment("Exiting Action Group [disableTableRatesShippingMethod] AdminChangeTableRatesShippingMethodStatusActionGroup");
		$I->comment("Entering Action Group [saveSystemConfig] AdminSaveConfigActionGroup");
		$I->click("#save"); // stepKey: clickSaveConfigBtnSaveSystemConfig
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveSystemConfig
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveSystemConfig
		$I->comment("Exiting Action Group [saveSystemConfig] AdminSaveConfigActionGroup");
	}
}
