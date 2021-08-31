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
 * @Title("MC-6405: Displaying of Table Rates for Armed Forces Europe (AE)")
 * @Description("Displaying of Table Rates for Armed Forces Europe (AE)<h3>Test files</h3>app/code/Magento/Shipping/Test/Mftf/Test/StorefrontDisplayTableRatesShippingMethodForAETest.xml<br>")
 * @TestCaseId("MC-6405")
 * @group shipping
 */
class StorefrontDisplayTableRatesShippingMethodForAETestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_ArmedForcesEurope", [], []); // stepKey: createCustomer
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
		$I->comment("Customer Log Out");
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDisplayTableRatesShippingMethodForAETest(AcceptanceTester $I)
	{
		$I->comment("Admin Configuration: enable Table Rates and import CSV file with the rates");
		$I->comment("Entering Action Group [openShippingMethodConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/carriers/"); // stepKey: navigateToAdminShippingMethodsPageOpenShippingMethodConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForAdminShippingMethodsPageToLoadOpenShippingMethodConfigPage
		$I->comment("Exiting Action Group [openShippingMethodConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
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
		$I->comment("Entering Action Group [enableTableRatesShippingMethod] AdminChangeTableRatesShippingMethodStatusActionGroup");
		$I->conditionalClick("#carriers_tablerate-head", "#carriers_tablerate_active", false); // stepKey: expandTabEnableTableRatesShippingMethod
		$I->uncheckOption("#carriers_tablerate_active_inherit"); // stepKey: uncheckUseSystemValueEnableTableRatesShippingMethod
		$I->selectOption("#carriers_tablerate_active", "1"); // stepKey: changeTableRatesMethodStatusEnableTableRatesShippingMethod
		$I->comment("Exiting Action Group [enableTableRatesShippingMethod] AdminChangeTableRatesShippingMethodStatusActionGroup");
		$I->attachFile("#carriers_tablerate_import", "tablerates.csv"); // stepKey: attachFileForImport
		$I->comment("Entering Action Group [saveConfig] AdminSaveConfigActionGroup");
		$I->click("#save"); // stepKey: clickSaveConfigBtnSaveConfig
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveConfig
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveConfig
		$I->comment("Exiting Action Group [saveConfig] AdminSaveConfigActionGroup");
		$I->comment("Login as created customer");
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
		$I->comment("Add the created product to the shopping cart");
		$I->comment("Entering Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Proceed to Checkout from the mini cart");
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Shipping Method: select table rate");
		$I->comment("Entering Action Group [assertShippingMethodAvailable] AssertStoreFrontShippingMethodAvailableActionGroup");
		$I->waitForElementVisible("//div[@id='checkout-shipping-method-load']//td[contains(., 'Best Way')]/..", 30); // stepKey: waitForShippingMethodLoadAssertShippingMethodAvailable
		$I->seeElement("//div[@id='checkout-shipping-method-load']//td[contains(., 'Best Way')]/.."); // stepKey: seeShippingMethodAssertShippingMethodAvailable
		$I->comment("Exiting Action Group [assertShippingMethodAvailable] AssertStoreFrontShippingMethodAvailableActionGroup");
		$I->comment("Entering Action Group [setShippingMethodTableRate] StorefrontSetShippingMethodActionGroup");
		$I->checkOption("//div[@id='checkout-shipping-method-load']//td[contains(., 'Best Way')]/..//input"); // stepKey: selectFlatRateShippingMethodSetShippingMethodTableRate
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSetShippingMethodTableRate
		$I->comment("Exiting Action Group [setShippingMethodTableRate] StorefrontSetShippingMethodActionGroup");
		$I->comment("Proceed to Review and Payments section");
		$I->comment("Entering Action Group [clickToSaveShippingInfo] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickToSaveShippingInfo
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickToSaveShippingInfoWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonClickToSaveShippingInfo
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonClickToSaveShippingInfoWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickToSaveShippingInfo
		$I->waitForPageLoad(30); // stepKey: clickNextClickToSaveShippingInfoWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearClickToSaveShippingInfo
		$I->comment("Exiting Action Group [clickToSaveShippingInfo] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForReviewAndPaymentsPageIsLoaded
		$I->comment("Place order and assert the message of success");
		$I->comment("Entering Action Group [placeOrderProductSuccessful] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrderProductSuccessful
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderProductSuccessfulWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrderProductSuccessful
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderProductSuccessfulWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPlaceOrderProductSuccessful
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrderProductSuccessful
		$I->comment("Exiting Action Group [placeOrderProductSuccessful] ClickPlaceOrderActionGroup");
	}
}
