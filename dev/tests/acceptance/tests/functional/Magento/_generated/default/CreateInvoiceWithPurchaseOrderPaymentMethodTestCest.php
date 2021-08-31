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
 * @Title("MC-15870: Create invoice with purchase order payment method test")
 * @Description("Create invoice with purchase order payment method<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/CreateInvoiceWithPurchaseOrderPaymentMethodTest.xml<br>")
 * @TestCaseId("MC-15870")
 * @group sales
 * @group mtf_migrated
 */
class CreateInvoiceWithPurchaseOrderPaymentMethodTestCest
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
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Create simple product");
		$createSimpleProductFields['price'] = "100";
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], $createSimpleProductFields); // stepKey: createSimpleProduct
		$I->comment("Enable payment method");
		$enablePaymentMethod = $I->magentoCLI("config:set payment/purchaseorder/active 1", 60); // stepKey: enablePaymentMethod
		$I->comment($enablePaymentMethod);
		$I->comment("Enable payment method");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Disable payment method");
		$disablePaymentMethod = $I->magentoCLI("config:set payment/purchaseorder/active 0", 60); // stepKey: disablePaymentMethod
		$I->comment($disablePaymentMethod);
		$I->comment("Logout customer");
		$I->comment("Entering Action Group [customerLogoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogoutStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogoutStorefront
		$I->comment("Exiting Action Group [customerLogoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Delete product");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Log out");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Disable payment method");
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
	 * @Stories({"Create Invoice for Offline Payment Methods"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CreateInvoiceWithPurchaseOrderPaymentMethodTest(AcceptanceTester $I)
	{
		$I->comment("Create order");
		$I->comment("Entering Action Group [goToCreateOrderPage] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadGoToCreateOrderPage
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleGoToCreateOrderPage
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderGoToCreateOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadGoToCreateOrderPage
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersGoToCreateOrderPageWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailGoToCreateOrderPage
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadGoToCreateOrderPage
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadGoToCreateOrderPage
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsGoToCreateOrderPage
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsGoToCreateOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectGoToCreateOrderPage
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleGoToCreateOrderPage
		$I->comment("Exiting Action Group [goToCreateOrderPage] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Add product to order");
		$I->comment("Entering Action Group [addProductToOrder] AddSimpleProductWithQtyToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "2"); // stepKey: fillProductQtyAddProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddProductToOrder
		$I->comment("Exiting Action Group [addProductToOrder] AddSimpleProductWithQtyToOrderActionGroup");
		$I->comment("Select shipping method");
		$I->comment("Entering Action Group [openShippingMethod] AdminClickGetShippingMethodsAndRatesActionGroup");
		$I->click("//span[text()='Get shipping methods and rates']"); // stepKey: openShippingMethodOpenShippingMethod
		$I->waitForPageLoad(60); // stepKey: openShippingMethodOpenShippingMethodWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsOpenShippingMethod
		$I->comment("Exiting Action Group [openShippingMethod] AdminClickGetShippingMethodsAndRatesActionGroup");
		$I->comment("Adding the comment to replace action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [chooseShippingMethod] AdminSelectFixedShippingMethodActionGroup");
		$I->click("//label[contains(text(), 'Fixed')]"); // stepKey: chooseShippingMethodChooseShippingMethod
		$I->waitForPageLoad(60); // stepKey: chooseShippingMethodChooseShippingMethodWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodLoadChooseShippingMethod
		$I->comment("Exiting Action Group [chooseShippingMethod] AdminSelectFixedShippingMethodActionGroup");
		$I->comment("Adding the comment to replace action for preserving Backward Compatibility");
		$I->comment("Select cash on delivery payment method");
		$I->comment("Entering Action Group [selectPaymentMethod] SelectPurchaseOrderPaymentMethodActionGroup");
		$I->waitForElementVisible("#order-billing_method", 30); // stepKey: waitForPaymentOptionsSelectPaymentMethod
		$I->conditionalClick("#p_method_purchaseorder", "#p_method_purchaseorder", true); // stepKey: checkPurchaseOrderOptionSelectPaymentMethod
		$I->waitForPageLoad(30); // stepKey: checkPurchaseOrderOptionSelectPaymentMethodWaitForPageLoad
		$I->fillField("#po_number", "12345"); // stepKey: fillPurchaseOrderNumberSelectPaymentMethod
		$I->comment("Exiting Action Group [selectPaymentMethod] SelectPurchaseOrderPaymentMethodActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocus
		$I->waitForPageLoad(30); // stepKey: waitForJavascriptToFinish
		$I->comment("Submit order");
		$I->comment("Entering Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->scrollTo("#submit_order_top_button"); // stepKey: scrollToSubmitButtonSubmitOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitButtonSubmitOrderWaitForPageLoad
		$I->click("#submit_order_top_button"); // stepKey: submitOrderSubmitOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->comment("Grab order id");
		$getOrderId = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: getOrderId
		$I->comment("Open created order");
		$I->comment("Entering Action Group [goToOrdersPage] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToOrdersPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToOrdersPage
		$I->comment("Exiting Action Group [goToOrdersPage] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [filterOrdersGridById] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrdersGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrdersGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrdersGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$getOrderId"); // stepKey: fillOrderIdFilterFilterOrdersGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrdersGridById
		$I->comment("Exiting Action Group [filterOrdersGridById] FilterOrderGridByIdActionGroup");
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: clickCreatedOrderInGrid
		$I->waitForPageLoad(60); // stepKey: clickCreatedOrderInGridWaitForPageLoad
		$I->comment("Go to invoice tab and fill data");
		$I->comment("Entering Action Group [clickInvoiceAction] AdminClickInvoiceButtonOrderViewActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceActionClickInvoiceAction
		$I->waitForPageLoad(30); // stepKey: clickInvoiceActionClickInvoiceActionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageClickInvoiceAction
		$I->comment("Exiting Action Group [clickInvoiceAction] AdminClickInvoiceButtonOrderViewActionGroup");
		$I->fillField(".input-text.admin__control-text.qty-input", "1"); // stepKey: fillInvoiceQuantity
		$I->waitForPageLoad(30); // stepKey: fillInvoiceQuantityWaitForPageLoad
		$I->click(".update-button"); // stepKey: clickUpdateQtyInvoiceBtn
		$I->waitForPageLoad(30); // stepKey: clickUpdateQtyInvoiceBtnWaitForPageLoad
		$I->fillField("[name='invoice[comment_text]']", "comment"); // stepKey: writeComment
		$I->waitForPageLoad(30); // stepKey: writeCommentWaitForPageLoad
		$I->comment("Entering Action Group [clickSubmitInvoice] AdminInvoiceClickSubmitActionGroup");
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: clickSubmitInvoiceClickSubmitInvoice
		$I->waitForPageLoad(60); // stepKey: clickSubmitInvoiceClickSubmitInvoiceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForInvoiceToBeCreatedClickSubmitInvoice
		$I->comment("Exiting Action Group [clickSubmitInvoice] AdminInvoiceClickSubmitActionGroup");
		$I->comment("Assert invoice with shipment success message");
		$I->see("The invoice has been created.", "div.message-success"); // stepKey: seeSuccessMessage
		$I->comment("Login as customer");
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
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLogin
		$I->comment("Open My Account > My Orders");
		$I->comment("Entering Action Group [goToMyAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageGoToMyAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToMyAccountPage
		$I->comment("Exiting Action Group [goToMyAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->comment("Entering Action Group [goToSidebarMenu] StorefrontCustomerGoToSidebarMenu");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Orders']"); // stepKey: goToAddressBookGoToSidebarMenu
		$I->waitForPageLoad(60); // stepKey: goToAddressBookGoToSidebarMenuWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToSidebarMenu
		$I->comment("Exiting Action Group [goToSidebarMenu] StorefrontCustomerGoToSidebarMenu");
		$I->comment("Assert invoiced amount on frontend");
		$I->click("//td[contains(concat(' ',normalize-space(@class),' '),' col actions ')]/a[contains(concat(' ',normalize-space(@class),' '),' action view ')]"); // stepKey: clickViewOrder
		$I->click("//a[contains(text(), 'Invoices')]"); // stepKey: clickInvoiceTabOnStorefront
		$I->see("$110.00", "[data-th='Grand Total'] .price"); // stepKey: seePrice
		$I->comment("Select purchase order payment method");
	}
}
