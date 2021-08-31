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
 * @Title("MC-15867: Create invoice with shipment and check invoiced order test")
 * @Description("Create invoice with shipment for offline payment methods and check invoiced order on admin dashboard<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/CreateInvoiceWithShipmentAndCheckInvoicedOrderTest.xml<br>")
 * @TestCaseId("MC-15867")
 * @group sales
 * @group mtf_migrated
 */
class CreateInvoiceWithShipmentAndCheckInvoicedOrderTestCest
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
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->comment("Enable charts");
		$enableDashboardCharts = $I->magentoCLI("config:set admin/dashboard/enable_charts 1", 60); // stepKey: enableDashboardCharts
		$I->comment($enableDashboardCharts);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Disable charts");
		$disableDashboardCharts = $I->magentoCLI("config:set admin/dashboard/enable_charts 0", 60); // stepKey: disableDashboardCharts
		$I->comment($disableDashboardCharts);
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
	public function CreateInvoiceWithShipmentAndCheckInvoicedOrderTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [addProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddProductToOrder
		$I->comment("Exiting Action Group [addProductToOrder] AddSimpleProductToOrderActionGroup");
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
		$I->click(".order-shipping-address input[name='invoice[do_shipment]']"); // stepKey: createShipment
		$I->fillField("[name='invoice[comment_text]']", "comment"); // stepKey: writeComment
		$I->waitForPageLoad(30); // stepKey: writeCommentWaitForPageLoad
		$I->comment("Entering Action Group [clickSubmitInvoice] AdminInvoiceClickSubmitActionGroup");
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: clickSubmitInvoiceClickSubmitInvoice
		$I->waitForPageLoad(60); // stepKey: clickSubmitInvoiceClickSubmitInvoiceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForInvoiceToBeCreatedClickSubmitInvoice
		$I->comment("Exiting Action Group [clickSubmitInvoice] AdminInvoiceClickSubmitActionGroup");
		$I->comment("Assert invoice with shipment success message");
		$I->see("You created the invoice and shipment.", "div.message-success"); // stepKey: seeSuccessMessage
		$I->comment("Assert order graph image is visible on admin dashboard");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/dashboard/"); // stepKey: amOnDashboardPage
		$I->waitForPageLoad(30); // stepKey: waitForDashboardPageLoad
		$I->comment("Entering Action Group [seeOrderGraphImage] AssertOrderGraphImageOnDashboardActionGroup");
		$I->click("#diagram_tab_orders"); // stepKey: clickOrdersBtnSeeOrderGraphImage
		$I->seeElement("#diagram_tab_orders_content #chart_orders_period"); // stepKey: seeOrdersChartSeeOrderGraphImage
		$I->comment("Exiting Action Group [seeOrderGraphImage] AssertOrderGraphImageOnDashboardActionGroup");
		$I->comment("Assert invoice in invoices grid");
		$I->comment("Entering Action Group [filterInvoiceGridByOrderId] FilterInvoiceGridByOrderIdWithCleanFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/invoice/"); // stepKey: goToInvoicesFilterInvoiceGridByOrderId
		$I->conditionalClick("button.action-clear", "button.action-clear", true); // stepKey: clearFiltersFilterInvoiceGridByOrderId
		$I->waitForPageLoad(30); // stepKey: clearFiltersFilterInvoiceGridByOrderIdWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: clickFilterFilterInvoiceGridByOrderId
		$I->fillField("input[name='order_increment_id']", "$getOrderId"); // stepKey: fillOrderIdForFilterFilterInvoiceGridByOrderId
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterInvoiceGridByOrderId
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterInvoiceGridByOrderIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersApplyFilterInvoiceGridByOrderId
		$I->comment("Exiting Action Group [filterInvoiceGridByOrderId] FilterInvoiceGridByOrderIdWithCleanFiltersActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: opeCreatedInvoice
		$I->waitForPageLoad(30); // stepKey: waitForInvoiceDetailsPageToLoad
		$grabInvoiceId = $I->grabFromCurrentUrl("~/invoice_id/(\d+)/~"); // stepKey: grabInvoiceId
		$I->comment("Assert no invoice button");
		$I->comment("Entering Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToOrders
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToOrders
		$I->comment("Exiting Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [filterOrderGridByIdForAssertingInvoiceBtn] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridByIdForAssertingInvoiceBtn
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridByIdForAssertingInvoiceBtn
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdForAssertingInvoiceBtn
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdForAssertingInvoiceBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridByIdForAssertingInvoiceBtn
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridByIdForAssertingInvoiceBtn
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdForAssertingInvoiceBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridByIdForAssertingInvoiceBtn
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$getOrderId"); // stepKey: fillOrderIdFilterFilterOrderGridByIdForAssertingInvoiceBtn
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdForAssertingInvoiceBtn
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdForAssertingInvoiceBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridByIdForAssertingInvoiceBtn
		$I->comment("Exiting Action Group [filterOrderGridByIdForAssertingInvoiceBtn] FilterOrderGridByIdActionGroup");
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: clickOrderInGrid
		$I->waitForPageLoad(60); // stepKey: clickOrderInGridWaitForPageLoad
		$I->dontSeeElement("//button[@title='Invoice']"); // stepKey: dontSeeInvoiceBtn
		$I->comment("Assert invoice in invoices tab");
		$I->click("#sales_order_view_tabs_order_invoices"); // stepKey: clickInvoicesTabOrdersPage
		$I->waitForPageLoad(30); // stepKey: clickInvoicesTabOrdersPageWaitForPageLoad
		$I->conditionalClick("//div[@id='sales_order_view_tabs_order_invoices_content']//button[@data-action='grid-filter-reset']", "//div[@id='sales_order_view_tabs_order_invoices_content']//button[@data-action='grid-filter-reset']", true); // stepKey: clearInvoiceFilters
		$I->waitForPageLoad(30); // stepKey: clearInvoiceFiltersWaitForPageLoad
		$I->click("//div[@id='sales_order_view_tabs_order_invoices_content']//button[@data-action='grid-filter-expand']"); // stepKey: openOrderInvoicesGridFilters
		$I->waitForPageLoad(30); // stepKey: openOrderInvoicesGridFiltersWaitForPageLoad
		$I->fillField("//div[@id='sales_order_view_tabs_order_invoices_content']//input[@name='increment_id']", "$grabInvoiceId"); // stepKey: fillInvoiceIdFilter
		$I->waitForPageLoad(30); // stepKey: fillInvoiceIdFilterWaitForPageLoad
		$I->fillField("[name='grand_total[from]']", "128.00"); // stepKey: fillAmountFromFilter
		$I->waitForPageLoad(30); // stepKey: fillAmountFromFilterWaitForPageLoad
		$I->fillField("[name='grand_total[to]']", "128.00"); // stepKey: fillAmountToFilter
		$I->waitForPageLoad(30); // stepKey: fillAmountToFilterWaitForPageLoad
		$I->click("//div[@id='sales_order_view_tabs_order_invoices_content']//button[@data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFilters
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersWaitForPageLoad
		$I->dontSeeElement(".data-grid-tr-no-data td"); // stepKey: assertThatInvoiceGridNotEmpty
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
		$I->see("128.00", "[data-th='Grand Total'] .price"); // stepKey: seePrice
		$I->comment("Assert shipment in grid");
		$I->comment("Entering Action Group [filterShipmentGridByOrderId] FilterShipmentGridByOrderIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/shipment/"); // stepKey: goToShipmentsFilterShipmentGridByOrderId
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadFilterShipmentGridByOrderId
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearOrderFiltersFilterShipmentGridByOrderId
		$I->waitForPageLoad(30); // stepKey: clearOrderFiltersFilterShipmentGridByOrderIdWaitForPageLoad
		$I->click("[data-action='grid-filter-expand']"); // stepKey: clickFilterFilterShipmentGridByOrderId
		$I->fillField("input[name='order_increment_id']", "$getOrderId"); // stepKey: fillOrderIdForFilterFilterShipmentGridByOrderId
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterShipmentGridByOrderId
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterShipmentGridByOrderIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersApplyFilterShipmentGridByOrderId
		$I->comment("Exiting Action Group [filterShipmentGridByOrderId] FilterShipmentGridByOrderIdActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: openCreatedShipment
		$I->waitForPageLoad(30); // stepKey: waitForShipmentDetailsPageToLoad
		$grabShipmentId = $I->grabFromCurrentUrl("~/shipment_id/(\d+)/~"); // stepKey: grabShipmentId
		$I->comment("Assert no ship button");
		$I->comment("Entering Action Group [goToAdminOrdersPage] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToAdminOrdersPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToAdminOrdersPage
		$I->comment("Exiting Action Group [goToAdminOrdersPage] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [filterOrderGridByIdForAssertingShipBtn] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridByIdForAssertingShipBtn
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridByIdForAssertingShipBtn
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdForAssertingShipBtn
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdForAssertingShipBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridByIdForAssertingShipBtn
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridByIdForAssertingShipBtn
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdForAssertingShipBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridByIdForAssertingShipBtn
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$getOrderId"); // stepKey: fillOrderIdFilterFilterOrderGridByIdForAssertingShipBtn
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdForAssertingShipBtn
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdForAssertingShipBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridByIdForAssertingShipBtn
		$I->comment("Exiting Action Group [filterOrderGridByIdForAssertingShipBtn] FilterOrderGridByIdActionGroup");
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: selectOrderInGrid
		$I->waitForPageLoad(60); // stepKey: selectOrderInGridWaitForPageLoad
		$I->dontSeeElement("//button[@title='Ship']"); // stepKey: dontSeeShipBtn
		$I->comment("Assert shipment in shipments tab");
		$I->click("#sales_order_view_tabs_order_shipments"); // stepKey: clickShipmentsTab
		$I->waitForPageLoad(30); // stepKey: waitOrderShipTabToLoad
		$I->conditionalClick("//div[@id='sales_order_view_tabs_order_shipments_content']//button[@data-action='grid-filter-reset']", "//div[@id='sales_order_view_tabs_order_shipments_content']//button[@data-action='grid-filter-reset']", true); // stepKey: clearShipmentsFilters
		$I->waitForPageLoad(30); // stepKey: clearShipmentsFiltersWaitForPageLoad
		$I->click("//div[@id='sales_order_view_tabs_order_shipments_content']//button[@data-action='grid-filter-expand']"); // stepKey: openOrderShipmentsGridFilters
		$I->waitForPageLoad(30); // stepKey: openOrderShipmentsGridFiltersWaitForPageLoad
		$I->fillField("//div[@id='sales_order_view_tabs_order_shipments_content']//input[@name='increment_id']", "$grabShipmentId"); // stepKey: fillShipmentsIdFilter
		$I->waitForPageLoad(30); // stepKey: fillShipmentsIdFilterWaitForPageLoad
		$I->fillField("[name='total_qty[from]']", "1.0000"); // stepKey: fillTotalQtyFromFilter
		$I->waitForPageLoad(30); // stepKey: fillTotalQtyFromFilterWaitForPageLoad
		$I->fillField("[name='total_qty[to]']", "1.0000"); // stepKey: fillTotalQtyToFilter
		$I->waitForPageLoad(30); // stepKey: fillTotalQtyToFilterWaitForPageLoad
		$I->click("//div[@id='sales_order_view_tabs_order_shipments_content']//button[@data-action='grid-filter-apply']"); // stepKey: clickApplyFilters
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersWaitForPageLoad
		$I->dontSeeElement(".data-grid-tr-no-data td"); // stepKey: assertThatShipmentGridNotEmpty
		$I->comment("Assert invoice items");
		$I->comment("Entering Action Group [filterInvoiceByOrderId] FilterInvoiceGridByOrderIdWithCleanFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/invoice/"); // stepKey: goToInvoicesFilterInvoiceByOrderId
		$I->conditionalClick("button.action-clear", "button.action-clear", true); // stepKey: clearFiltersFilterInvoiceByOrderId
		$I->waitForPageLoad(30); // stepKey: clearFiltersFilterInvoiceByOrderIdWaitForPageLoad
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: clickFilterFilterInvoiceByOrderId
		$I->fillField("input[name='order_increment_id']", "$getOrderId"); // stepKey: fillOrderIdForFilterFilterInvoiceByOrderId
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterInvoiceByOrderId
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterInvoiceByOrderIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersApplyFilterInvoiceByOrderId
		$I->comment("Exiting Action Group [filterInvoiceByOrderId] FilterInvoiceGridByOrderIdWithCleanFiltersActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: openInvoice
		$I->waitForPageLoad(30); // stepKey: waitForInvoicePageToLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".col-product .product-title"); // stepKey: seeProductNameInInvoiceItems
		$I->see("1", "td.col-qty"); // stepKey: seeProductQtyInInvoiceItems
		$I->see($I->retrieveEntityField('createSimpleProduct', 'price', 'test'), ".col-total .price"); // stepKey: seeProductTotalPriceInInvoiceItems
	}
}
