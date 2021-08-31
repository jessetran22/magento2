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
 * @Title("MC-15863: Create Credit Memo with cash on delivery payment method")
 * @Description("Create Credit Memo with cash on delivery payment and assert 0 shipping refund<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateCreditMemoForOrderWithCashOnDeliveryTest.xml<br>")
 * @TestCaseId("MC-15863")
 * @group sales
 * @group mtf_migrated
 */
class AdminCreateCreditMemoForOrderWithCashOnDeliveryTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "defaultSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$enableBankTransfer = $I->magentoCLI("config:set payment/cashondelivery/active 1", 60); // stepKey: enableBankTransfer
		$I->comment($enableBankTransfer);
		$I->createEntity("createCustomerCart", "hook", "CustomerCart", ["createCustomer"], []); // stepKey: createCustomerCart
		$I->createEntity("addCartItem", "hook", "CustomerCartItem", ["createCustomerCart", "createProduct"], []); // stepKey: addCartItem
		$I->createEntity("addCustomerOrderAddress", "hook", "CustomerAddressInformation", ["createCustomerCart"], []); // stepKey: addCustomerOrderAddress
		$I->updateEntity("createCustomerCart", "hook", "CashOnDeliveryOrderPaymentMethod",["createCustomerCart"]); // stepKey: sendCustomerPaymentInformation
		$I->createEntity("invoiceOrderOne", "hook", "Invoice", ["createCustomerCart"], []); // stepKey: invoiceOrderOne
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$disableBankTransfer = $I->magentoCLI("config:set payment/cashondelivery/active 0", 60); // stepKey: disableBankTransfer
		$I->comment($disableBankTransfer);
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Credit memo entity"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCreditMemoForOrderWithCashOnDeliveryTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [onOrderPage] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageOnOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageOnOrderPage
		$I->comment("Exiting Action Group [onOrderPage] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [clearFilters] AdminOrdersGridClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: goToGridOrdersPageClearFilters
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClearFilters
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header .admin__data-grid-filters-current._show", true); // stepKey: clickOnButtonToRemoveFiltersIfPresentClearFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitAfterClearFiltersClearFilters
		$I->comment("Exiting Action Group [clearFilters] AdminOrdersGridClearFiltersActionGroup");
		$grabOrderId = $I->grabTextFrom("//input[@class='admin__control-checkbox' and @value=" . $I->retrieveEntityField('createCustomerCart', 'return', 'test') . "]/parent::label/parent::td/following-sibling::td"); // stepKey: grabOrderId
		$I->comment("Entering Action Group [filterOrdersGridById] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrdersGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrdersGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrdersGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderId); // stepKey: fillOrderIdFilterFilterOrdersGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrdersGridByIdWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageFilterOrdersGridById
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageFilterOrdersGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedFilterOrdersGridById
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrdersGridById
		$I->comment("Exiting Action Group [filterOrdersGridById] OpenOrderByIdActionGroup");
		$I->comment("Entering Action Group [fillCreditMemoRefund] AdminOpenAndFillCreditMemoRefundActionGroup");
		$I->comment("Click 'Credit Memo' button");
		$I->click("#order_creditmemo"); // stepKey: clickCreateCreditMemoFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: clickCreateCreditMemoFillCreditMemoRefundWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_creditmemo/new/order_id/"); // stepKey: seeNewCreditMemoPageFillCreditMemoRefund
		$I->see("New Memo", ".page-header h1.page-title"); // stepKey: seeNewMemoInPageTitleFillCreditMemoRefund
		$I->comment("Fill data from dataset: refund");
		$I->scrollTo("#creditmemo_item_container span.title"); // stepKey: scrollToItemsToRefundFillCreditMemoRefund
		$I->fillField(".order-creditmemo-tables tbody:nth-of-type(1) .col-refund .qty-input", "1"); // stepKey: fillQtyToRefundFillCreditMemoRefund
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForActivateButtonFillCreditMemoRefund
		$I->conditionalClick(".order-creditmemo-tables tfoot button[data-ui-id='order-items-update-button']", ".order-creditmemo-tables tfoot button[data-ui-id='order-items-update-button'].disabled", false); // stepKey: clickUpdateButtonFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: clickUpdateButtonFillCreditMemoRefundWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForUpdateFillCreditMemoRefund
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[shipping_amount]']", "0"); // stepKey: fillShippingFillCreditMemoRefund
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[adjustment_positive]']", "5"); // stepKey: fillAdjustmentRefundFillCreditMemoRefund
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[adjustment_negative]']", "10"); // stepKey: fillAdjustmentFeeFillCreditMemoRefund
		$I->waitForElementVisible(".update-totals-button", 30); // stepKey: waitForUpdateTotalsButtonFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: waitForUpdateTotalsButtonFillCreditMemoRefundWaitForPageLoad
		$I->click(".update-totals-button"); // stepKey: clickUpdateTotalsFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: clickUpdateTotalsFillCreditMemoRefundWaitForPageLoad
		$I->checkOption(".order-totals-actions #send_email"); // stepKey: checkSendEmailCopyFillCreditMemoRefund
		$I->comment("Exiting Action Group [fillCreditMemoRefund] AdminOpenAndFillCreditMemoRefundActionGroup");
		$I->comment("Entering Action Group [clickRefundOffline] AdminClickRefundOfflineOnCreditMemoDetailPageActionGroup");
		$I->click(".order-totals-actions button[data-ui-id='order-items-submit-button']"); // stepKey: clickRefundOfflineClickRefundOffline
		$I->waitForPageLoad(60); // stepKey: clickRefundOfflineClickRefundOfflineWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccesMessageClickRefundOffline
		$I->see("You created the credit memo.", "#messages div.message-success"); // stepKey: seeSuccessMessageClickRefundOffline
		$I->comment("Exiting Action Group [clickRefundOffline] AdminClickRefundOfflineOnCreditMemoDetailPageActionGroup");
		$I->comment("Entering Action Group [openCreditMemo] AdminOpenCreditMemoFromOrderPageActionGroup");
		$I->conditionalClick("#sales_order_view_tabs_order_creditmemos", "#sales_order_view_tabs_order_creditmemos_content .data-grid tbody > tr:nth-of-type(1) a[href*='order_creditmemo/view']", false); // stepKey: openCreditMemosTabOpenCreditMemo
		$I->waitForElementVisible("div#sales_order_view_tabs_order_creditmemos_content a.action-menu-item", 30); // stepKey: waitForCreditMemosTabOpenedOpenCreditMemo
		$I->click("#sales_order_view_tabs_order_creditmemos_content .data-grid tbody > tr:nth-of-type(1) a[href*='order_creditmemo/view']"); // stepKey: viewMemoOpenCreditMemo
		$I->waitForPageLoad(30); // stepKey: waitForCreditMemoOpenedOpenCreditMemo
		$I->comment("Exiting Action Group [openCreditMemo] AdminOpenCreditMemoFromOrderPageActionGroup");
		$I->comment("Entering Action Group [assertCreditMemoViewPageTotals] AssertAdminCreditMemoViewPageTotalsActionGroup");
		$I->see("$560.00", "//td[contains(text(), 'Subtotal')]/following-sibling::td//span[@class='price']"); // stepKey: seeSubtotalAssertCreditMemoViewPageTotals
		$I->see("$5.00", "//td[contains(text(), 'Adjustment Refund')]/following-sibling::td//span[@class='price']"); // stepKey: seeAdjustmentRefundAssertCreditMemoViewPageTotals
		$I->see("$10.00", "//td[contains(text(), 'Adjustment Fee')]/following-sibling::td//span[@class='price']"); // stepKey: seeAdjustmentFeeAssertCreditMemoViewPageTotals
		$I->see("$555.00", ".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: seeGrandTotalAssertCreditMemoViewPageTotals
		$I->comment("Exiting Action Group [assertCreditMemoViewPageTotals] AssertAdminCreditMemoViewPageTotalsActionGroup");
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
		$I->comment("Entering Action Group [openOrderDetailPage] StorefrontGoToCustomerOrderDetailsPageActionGroup");
		$I->amOnPage("sales/order/view/order_id/" . $I->retrieveEntityField('createCustomerCart', 'return', 'test')); // stepKey: goToOrdersPageOpenOrderDetailPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenOrderDetailPage
		$I->waitForText($grabOrderId, 30, "#maincontent .column.main [data-ui-id='page-title-wrapper']"); // stepKey: verifyOrderNoOpenOrderDetailPage
		$I->comment("Exiting Action Group [openOrderDetailPage] StorefrontGoToCustomerOrderDetailsPageActionGroup");
		$I->comment("Entering Action Group [clickRefund] StorefrontClickRefundTabCustomerOrderViewActionGroup");
		$I->click("//a[text()='Refunds']"); // stepKey: clickRefundTabClickRefund
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickRefund
		$I->comment("Exiting Action Group [clickRefund] StorefrontClickRefundTabCustomerOrderViewActionGroup");
		$I->see("555.00", "td[data-th='Grand Total'] > strong > span.price"); // stepKey: seeGrandTotal
	}
}
