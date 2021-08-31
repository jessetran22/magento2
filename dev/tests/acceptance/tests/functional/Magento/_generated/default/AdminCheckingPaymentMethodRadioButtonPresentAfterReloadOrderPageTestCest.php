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
 * @Title("MC-40878: Checking payment method radio button is presented after reloading the order page")
 * @Description("Checking payment method radio button is presented after reloading the order page<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCheckingPaymentMethodRadioButtonPresentAfterReloadOrderPageTest.xml<br>")
 * @TestCaseId("MC-40878")
 * @group sales
 */
class AdminCheckingPaymentMethodRadioButtonPresentAfterReloadOrderPageTestCest
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
		$I->comment("Enable Check/Money order payment method");
		$enableCheckMoneyOrderPayment = $I->magentoCLI("config:set payment/checkmo/active 1", 60); // stepKey: enableCheckMoneyOrderPayment
		$I->comment($enableCheckMoneyOrderPayment);
		$I->comment("Enable Bank Transfer Payment method");
		$enableBankTransferPayment = $I->magentoCLI("config:set payment/banktransfer/active 1", 60); // stepKey: enableBankTransferPayment
		$I->comment($enableBankTransferPayment);
		$I->comment("Create simple product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Login to Admin page");
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
		$I->comment("Disable Bank Transfer Payment method");
		$disableBankTransferPayment = $I->magentoCLI("config:set payment/banktransfer/active 0", 60); // stepKey: disableBankTransferPayment
		$I->comment($disableBankTransferPayment);
		$I->comment("Delete entities");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Logout from Admin page");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Sales"})
	 * @Stories({"Create order in Admin"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckingPaymentMethodRadioButtonPresentAfterReloadOrderPageTest(AcceptanceTester $I)
	{
		$I->comment("Create new order");
		$I->comment("Entering Action Group [navigateToNewOrderWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToNewOrderWithExistingCustomer
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToNewOrderWithExistingCustomer
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToNewOrderWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadNavigateToNewOrderWithExistingCustomer
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderWithExistingCustomerWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToNewOrderWithExistingCustomer
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadNavigateToNewOrderWithExistingCustomer
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadNavigateToNewOrderWithExistingCustomer
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderWithExistingCustomer
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderWithExistingCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToNewOrderWithExistingCustomer
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToNewOrderWithExistingCustomer
		$I->comment("Exiting Action Group [navigateToNewOrderWithExistingCustomer] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Add Simple product to order");
		$I->comment("Entering Action Group [addSimpleProductToTheOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSimpleProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSimpleProductToTheOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddSimpleProductToTheOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddSimpleProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddSimpleProductToTheOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSimpleProductToTheOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddSimpleProductToTheOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddSimpleProductToTheOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSimpleProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSimpleProductToTheOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSimpleProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSimpleProductToTheOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddSimpleProductToTheOrder
		$I->comment("Exiting Action Group [addSimpleProductToTheOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Assert label with radio button presents on the page");
		$I->comment("Entering Action Group [assertCheckMORadioButtonIsPresent] AssertAdminPaymentMethodRadioButtonExistsOnCreateOrderPageActionGroup");
		$I->conditionalClick("#order-billing_method_summary>a", "#order-billing_method_summary>a", true); // stepKey: clickGetAvailablePaymentMethodsAssertCheckMORadioButtonIsPresent
		$I->waitForPageLoad(30); // stepKey: clickGetAvailablePaymentMethodsAssertCheckMORadioButtonIsPresentWaitForPageLoad
		$I->waitForElementVisible("#order-billing_method", 30); // stepKey: waitForPaymentOptionsAssertCheckMORadioButtonIsPresent
		$I->seeElement("#order-billing_method_form .admin__field-option input[title='Check / Money order'] + label"); // stepKey: seeLabelWithRadioButtonAssertCheckMORadioButtonIsPresent
		$I->comment("Exiting Action Group [assertCheckMORadioButtonIsPresent] AssertAdminPaymentMethodRadioButtonExistsOnCreateOrderPageActionGroup");
		$I->comment("Entering Action Group [assertBankTransferRadioButtonIsPresent] AssertAdminPaymentMethodRadioButtonExistsOnCreateOrderPageActionGroup");
		$I->conditionalClick("#order-billing_method_summary>a", "#order-billing_method_summary>a", true); // stepKey: clickGetAvailablePaymentMethodsAssertBankTransferRadioButtonIsPresent
		$I->waitForPageLoad(30); // stepKey: clickGetAvailablePaymentMethodsAssertBankTransferRadioButtonIsPresentWaitForPageLoad
		$I->waitForElementVisible("#order-billing_method", 30); // stepKey: waitForPaymentOptionsAssertBankTransferRadioButtonIsPresent
		$I->seeElement("#order-billing_method_form .admin__field-option input[title='Bank Transfer Payment'] + label"); // stepKey: seeLabelWithRadioButtonAssertBankTransferRadioButtonIsPresent
		$I->comment("Exiting Action Group [assertBankTransferRadioButtonIsPresent] AssertAdminPaymentMethodRadioButtonExistsOnCreateOrderPageActionGroup");
		$I->comment("Entering Action Group [reloadPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadPage
		$I->comment("Exiting Action Group [reloadPage] ReloadPageActionGroup");
		$I->comment("Assert label with radio button presents after reload the page");
		$I->comment("Entering Action Group [assertCheckMORadioButtonIsPresentAfterReload] AssertAdminPaymentMethodRadioButtonExistsOnCreateOrderPageActionGroup");
		$I->conditionalClick("#order-billing_method_summary>a", "#order-billing_method_summary>a", true); // stepKey: clickGetAvailablePaymentMethodsAssertCheckMORadioButtonIsPresentAfterReload
		$I->waitForPageLoad(30); // stepKey: clickGetAvailablePaymentMethodsAssertCheckMORadioButtonIsPresentAfterReloadWaitForPageLoad
		$I->waitForElementVisible("#order-billing_method", 30); // stepKey: waitForPaymentOptionsAssertCheckMORadioButtonIsPresentAfterReload
		$I->seeElement("#order-billing_method_form .admin__field-option input[title='Check / Money order'] + label"); // stepKey: seeLabelWithRadioButtonAssertCheckMORadioButtonIsPresentAfterReload
		$I->comment("Exiting Action Group [assertCheckMORadioButtonIsPresentAfterReload] AssertAdminPaymentMethodRadioButtonExistsOnCreateOrderPageActionGroup");
		$I->comment("Entering Action Group [assertBankTransferRadioButtonIsPresentAfterReload] AssertAdminPaymentMethodRadioButtonExistsOnCreateOrderPageActionGroup");
		$I->conditionalClick("#order-billing_method_summary>a", "#order-billing_method_summary>a", true); // stepKey: clickGetAvailablePaymentMethodsAssertBankTransferRadioButtonIsPresentAfterReload
		$I->waitForPageLoad(30); // stepKey: clickGetAvailablePaymentMethodsAssertBankTransferRadioButtonIsPresentAfterReloadWaitForPageLoad
		$I->waitForElementVisible("#order-billing_method", 30); // stepKey: waitForPaymentOptionsAssertBankTransferRadioButtonIsPresentAfterReload
		$I->seeElement("#order-billing_method_form .admin__field-option input[title='Bank Transfer Payment'] + label"); // stepKey: seeLabelWithRadioButtonAssertBankTransferRadioButtonIsPresentAfterReload
		$I->comment("Exiting Action Group [assertBankTransferRadioButtonIsPresentAfterReload] AssertAdminPaymentMethodRadioButtonExistsOnCreateOrderPageActionGroup");
	}
}
