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
 * @Title("MC-16053: Assign custom order status not visible on storefront test")
 * @Description("Assign custom order status not visible on storefront<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AssignCustomOrderStatusNotVisibleOnStorefrontTest.xml<br>")
 * @TestCaseId("MC-16053")
 * @group sales
 * @group mtf_migrated
 */
class AssignCustomOrderStatusNotVisibleOnStorefrontTestCest
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
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Create product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
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
		$I->comment("Disable created order status");
		$rollbackNewOrderStatus = $I->magentoCLI("config:set payment/checkmo/order_status pending", 60); // stepKey: rollbackNewOrderStatus
		$I->comment($rollbackNewOrderStatus);
		$I->comment("Logout customer");
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->comment("Delete product");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
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
	 * @Features({"Sales"})
	 * @Stories({"Assign Custom Order Status"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AssignCustomOrderStatusNotVisibleOnStorefrontTest(AcceptanceTester $I)
	{
		$I->comment("Create order status");
		$I->comment("Entering Action Group [goToOrderStatusPage] AdminGoToOrderStatusPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_status"); // stepKey: goToOrderStatusPageGoToOrderStatusPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToOrderStatusPage
		$I->comment("Exiting Action Group [goToOrderStatusPage] AdminGoToOrderStatusPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickCreateNewStatus] AdminClickCreateNewStatusButtonOnOrderStatusPageActionGroup");
		$I->click("#add"); // stepKey: clickCreateNewStatusClickCreateNewStatus
		$I->waitForPageLoad(30); // stepKey: clickCreateNewStatusClickCreateNewStatusWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickCreateNewStatus
		$I->comment("Exiting Action Group [clickCreateNewStatus] AdminClickCreateNewStatusButtonOnOrderStatusPageActionGroup");
		$I->comment("Fill form and validate message");
		$I->comment("Entering Action Group [fillFormAndClickSave] AdminOrderStatusFormFillAndSave");
		$I->fillField("#edit_form [name=status]", "order_status" . msq("defaultOrderStatus")); // stepKey: fillStatusCodeFillFormAndClickSave
		$I->fillField("#edit_form [name=label]", "orderLabel" . msq("defaultOrderStatus")); // stepKey: fillStatusLabelFillFormAndClickSave
		$I->click("#save"); // stepKey: clickSaveStatusFillFormAndClickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveStatusFillFormAndClickSaveWaitForPageLoad
		$I->comment("Exiting Action Group [fillFormAndClickSave] AdminOrderStatusFormFillAndSave");
		$I->comment("Entering Action Group [seeFormSaveSuccess] AssertOrderStatusFormSaveSuccess");
		$I->see("You saved the order status.", "#messages div.message-success"); // stepKey: seeSuccessSeeFormSaveSuccess
		$I->comment("Exiting Action Group [seeFormSaveSuccess] AssertOrderStatusFormSaveSuccess");
		$I->comment("Assign status to state");
		$I->click("#assign"); // stepKey: clickAssignStatusBtn
		$I->waitForPageLoad(30); // stepKey: clickAssignStatusBtnWaitForPageLoad
		$I->selectOption("#status", "order_status" . msq("defaultOrderStatus")); // stepKey: selectOrderStatus
		$I->selectOption("#state", "Pending"); // stepKey: selectOrderState
		$I->checkOption("#is_default"); // stepKey: orderStatusAsDefault
		$I->uncheckOption("#visible_on_front"); // stepKey: visibleOnStorefront
		$I->click("#save"); // stepKey: clickSaveStatus
		$I->waitForPageLoad(30); // stepKey: clickSaveStatusWaitForPageLoad
		$I->see("You assigned the order status.", "#messages div.message-success"); // stepKey: seeSuccess
		$I->comment("Prepare data for constraints");
		$enableNewOrderStatus = $I->magentoCLI("config:set payment/checkmo/order_status orderLabel" . msq("defaultOrderStatus"), 60); // stepKey: enableNewOrderStatus
		$I->comment($enableNewOrderStatus);
		$I->comment("Assert order status in grid");
		$I->comment("Entering Action Group [filterOrderStatusGrid] FilterOrderStatusByLabelAndCodeActionGroup");
		$I->conditionalClick("//div[contains(concat(' ',normalize-space(@class),' '),' action-reset ')]", "//div[contains(concat(' ',normalize-space(@class),' '),' action-reset ')]", true); // stepKey: clearOrderStatusFiltersFilterOrderStatusGrid
		$I->waitForPageLoad(30); // stepKey: clearOrderStatusFiltersFilterOrderStatusGridWaitForPageLoad
		$I->fillField("#sales_order_status_grid_filter_label", "orderLabel" . msq("defaultOrderStatus")); // stepKey: fillStatusLabelFilterOrderStatusGrid
		$I->fillField("#sales_order_status_grid_filter_status", "order_status" . msq("defaultOrderStatus")); // stepKey: fillStatusCodeFilterOrderStatusGrid
		$I->click("[data-action='grid-filter-apply']"); // stepKey: clickSearchFilterOrderStatusGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchFilterOrderStatusGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchFilterOrderStatusGrid
		$I->comment("Exiting Action Group [filterOrderStatusGrid] FilterOrderStatusByLabelAndCodeActionGroup");
		$I->see("new[orderLabel" . msq("defaultOrderStatus") . "]", "//tr['1']//td[count(//div[contains(concat(' ',normalize-space(@class),' '),' admin__data-grid-wrap ')]//tr//th[contains(., 'State Code and Title')]/preceding-sibling::th) +1 ]"); // stepKey: seeOrderStatusInOrderGrid
		$I->waitForPageLoad(30); // stepKey: seeOrderStatusInOrderGridWaitForPageLoad
		$I->comment("Create order and grab order id");
		$I->comment("Entering Action Group [createNewOrder] CreateOrderActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_create/index"); // stepKey: navigateToNewOrderPageCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForNewOrderPageOpenedCreateNewOrder
		$I->click("(//td[contains(text(),'" . $I->retrieveEntityField('createCustomer', 'firstname', 'test') . "')])[1]"); // stepKey: chooseCustomerCreateNewOrder
		$I->waitForPageLoad(60); // stepKey: chooseCustomerCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageOpenedCreateNewOrder
		$I->click("#add_products"); // stepKey: clickOnAddProductsCreateNewOrder
		$I->waitForPageLoad(60); // stepKey: clickOnAddProductsCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductsListForOrderCreateNewOrder
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "')]"); // stepKey: chooseTheProductCreateNewOrder
		$I->waitForPageLoad(60); // stepKey: chooseTheProductCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickProductCreateNewOrder
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: addSelectedProductToOrderCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: addSelectedProductToOrderCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductAddedInOrderCreateNewOrder
		$I->click("//span[text()='Get shipping methods and rates']"); // stepKey: openShippingMethodCreateNewOrder
		$I->waitForPageLoad(60); // stepKey: openShippingMethodCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsCreateNewOrder
		$I->click("//label[contains(text(), 'Fixed')]"); // stepKey: chooseShippingMethodCreateNewOrder
		$I->waitForPageLoad(60); // stepKey: chooseShippingMethodCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsThickenedCreateNewOrder
		$I->click("#submit_order_top_button"); // stepKey: submitOrderCreateNewOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSubmitOrderCreateNewOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderCreateNewOrder
		$I->comment("Exiting Action Group [createNewOrder] CreateOrderActionGroup");
		$getOrderId = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: getOrderId
		$I->comment("Assert order status is correct");
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
		$I->see("orderLabel" . msq("defaultOrderStatus"), ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatus
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
		$I->comment("Open My Orders");
		$I->comment("Entering Action Group [goToCustomerDashboardPage] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageGoToCustomerDashboardPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCustomerDashboardPage
		$I->comment("Exiting Action Group [goToCustomerDashboardPage] StorefrontOpenMyAccountPageActionGroup");
		$I->comment("Entering Action Group [goToMyOrdersPage] StorefrontCustomerGoToSidebarMenu");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Orders']"); // stepKey: goToAddressBookGoToMyOrdersPage
		$I->waitForPageLoad(60); // stepKey: goToAddressBookGoToMyOrdersPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToMyOrdersPage
		$I->comment("Exiting Action Group [goToMyOrdersPage] StorefrontCustomerGoToSidebarMenu");
		$I->comment("Assert order not visible on My Orders");
		$I->see("You have placed no orders.", "//div[contains(concat(' ',normalize-space(@class),' '),' message info empty ')]/span"); // stepKey: seeEmptyMessage
		$I->comment("Cancel order");
		$I->comment("Entering Action Group [goToAdminOrdersPage] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToAdminOrdersPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToAdminOrdersPage
		$I->comment("Exiting Action Group [goToAdminOrdersPage] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [filterOrdersGridByOrderId] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrdersGridByOrderId
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrdersGridByOrderId
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrdersGridByOrderId
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrdersGridByOrderIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrdersGridByOrderId
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrdersGridByOrderId
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrdersGridByOrderIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrdersGridByOrderId
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$getOrderId"); // stepKey: fillOrderIdFilterFilterOrdersGridByOrderId
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrdersGridByOrderId
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrdersGridByOrderIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrdersGridByOrderId
		$I->comment("Exiting Action Group [filterOrdersGridByOrderId] FilterOrderGridByIdActionGroup");
		$I->checkOption("//td[count(//div[@data-role='grid-wrapper'])]//input"); // stepKey: selectOrder
		$I->comment("Entering Action Group [selectCancelOrderAction] SelectActionForOrdersActionGroup");
		$I->checkOption("//td[count(//div[@data-role='grid-wrapper'])]//input"); // stepKey: checkOrderSelectCancelOrderAction
		$I->click("//div[contains(concat(' ',normalize-space(@class),' '),' row-gutter ')]//button[@title='Select Items']"); // stepKey: clickOrderActionsSelectCancelOrderAction
		$I->waitForPageLoad(60); // stepKey: clickOrderActionsSelectCancelOrderActionWaitForPageLoad
		$I->click("//div[contains(concat(' ',normalize-space(@class),' '),' row-gutter ')]//span[text()='Cancel']"); // stepKey: changeOrdersActionSelectCancelOrderAction
		$I->waitForPageLoad(30); // stepKey: changeOrdersActionSelectCancelOrderActionWaitForPageLoad
		$I->comment("Exiting Action Group [selectCancelOrderAction] SelectActionForOrdersActionGroup");
		$I->see("We canceled 1 order(s).", "#messages div.message-success"); // stepKey: seeSuccessMessage
		$I->comment("Unassign order status");
		$I->comment("Entering Action Group [goToOrderStatus] AdminGoToOrderStatusPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_status"); // stepKey: goToOrderStatusPageGoToOrderStatus
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToOrderStatus
		$I->comment("Exiting Action Group [goToOrderStatus] AdminGoToOrderStatusPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [filterStatusGrid] FilterOrderStatusByLabelAndCodeActionGroup");
		$I->conditionalClick("//div[contains(concat(' ',normalize-space(@class),' '),' action-reset ')]", "//div[contains(concat(' ',normalize-space(@class),' '),' action-reset ')]", true); // stepKey: clearOrderStatusFiltersFilterStatusGrid
		$I->waitForPageLoad(30); // stepKey: clearOrderStatusFiltersFilterStatusGridWaitForPageLoad
		$I->fillField("#sales_order_status_grid_filter_label", "orderLabel" . msq("defaultOrderStatus")); // stepKey: fillStatusLabelFilterStatusGrid
		$I->fillField("#sales_order_status_grid_filter_status", "order_status" . msq("defaultOrderStatus")); // stepKey: fillStatusCodeFilterStatusGrid
		$I->click("[data-action='grid-filter-apply']"); // stepKey: clickSearchFilterStatusGrid
		$I->waitForPageLoad(30); // stepKey: clickSearchFilterStatusGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSearchFilterStatusGrid
		$I->comment("Exiting Action Group [filterStatusGrid] FilterOrderStatusByLabelAndCodeActionGroup");
		$I->click("[data-role=row] [data-column=unassign]"); // stepKey: unassignOrderStatus
		$I->waitForPageLoad(60); // stepKey: unassignOrderStatusWaitForPageLoad
		$I->see("You have unassigned the order status.", "#messages div.message-success"); // stepKey: seeMessage
	}
}
