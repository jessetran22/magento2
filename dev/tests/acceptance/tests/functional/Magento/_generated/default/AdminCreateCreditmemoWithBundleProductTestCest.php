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
 * @Title("[NO TESTCASEID]: Create Creditmemo in Admin with bundle product")
 * @Description("Create Creditmemo for bundle product with without receiving product back(all child item qty = 0)<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateCreditmemoWithBundleProductTest.xml<br>")
 * @group Sales
 */
class AdminCreateCreditmemoWithBundleProductTestCest
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
		$I->createEntity("setDefaultFlatRateShippingMethod", "hook", "FlatRateShippingMethodDefault", [], []); // stepKey: setDefaultFlatRateShippingMethod
		$I->createEntity("simpleCustomer", "hook", "Simple_US_Customer_CA", [], []); // stepKey: simpleCustomer
		$I->createEntity("simple1", "hook", "ApiProductWithDescription", [], []); // stepKey: simple1
		$I->createEntity("simple2", "hook", "ApiProductWithDescription", [], []); // stepKey: simple2
		$I->createEntity("product", "hook", "ApiBundleProduct", [], []); // stepKey: product
		$I->createEntity("checkboxBundleOption", "hook", "CheckboxOption", ["product"], []); // stepKey: checkboxBundleOption
		$createBundleLink1Fields['qty'] = "2";
		$createBundleLink1Fields['is_default'] = "1";
		$I->createEntity("createBundleLink1", "hook", "ApiBundleLink", ["product", "checkboxBundleOption", "simple1"], $createBundleLink1Fields); // stepKey: createBundleLink1
		$createBundleLink2Fields['qty'] = "2";
		$createBundleLink2Fields['is_default'] = "1";
		$I->createEntity("createBundleLink2", "hook", "ApiBundleLink", ["product", "checkboxBundleOption", "simple2"], $createBundleLink2Fields); // stepKey: createBundleLink2
		$I->createEntity("dropDownBundleOption", "hook", "DropDownBundleOption", ["product"], []); // stepKey: dropDownBundleOption
		$createBundleLink3Fields['qty'] = "2";
		$createBundleLink3Fields['is_default'] = "1";
		$I->createEntity("createBundleLink3", "hook", "ApiBundleLink", ["product", "dropDownBundleOption", "simple1"], $createBundleLink3Fields); // stepKey: createBundleLink3
		$createBundleLink4Fields['qty'] = "2";
		$I->createEntity("createBundleLink4", "hook", "ApiBundleLink", ["product", "dropDownBundleOption", "simple2"], $createBundleLink4Fields); // stepKey: createBundleLink4
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
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("simple1", "hook"); // stepKey: deleteSimple1
		$I->deleteEntity("simple2", "hook"); // stepKey: deleteSimple2
		$I->deleteEntity("product", "hook"); // stepKey: delete
		$I->deleteEntity("simpleCustomer", "hook"); // stepKey: deleteSimpleCustomer
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
	 * @Stories({"Github issue: #23440 fix Refund for bundle product without receiving product back"})
	 * @Features({"Sales"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCreditmemoWithBundleProductTest(AcceptanceTester $I)
	{
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
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('simpleCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToNewOrderWithExistingCustomer
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
		$I->comment("Entering Action Group [addBundleProductToOrder] AddBundleProductToOrderAndCheckPriceInGridActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddBundleProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('product', 'sku', 'test')); // stepKey: fillSkuFilterBundleAddBundleProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchBundleAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchBundleAddBundleProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddBundleProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectBundleProductAddBundleProductToOrder
		$I->waitForElementVisible("#product_composite_configure_input_qty", 30); // stepKey: waitForBundleOptionLoadAddBundleProductToOrder
		$I->wait(2); // stepKey: waitForOptionsToLoadAddBundleProductToOrder
		$I->fillField("#product_composite_configure_input_qty", "1"); // stepKey: fillQuantityAddBundleProductToOrder
		$I->click(".modal-header .page-actions button[data-role='action']"); // stepKey: clickOkAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickOkAddBundleProductToOrderWaitForPageLoad
		$grabProductPriceFromGridAddBundleProductToOrder = $I->grabTextFrom("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.price"); // stepKey: grabProductPriceFromGridAddBundleProductToOrder
		$I->assertEquals("$738.00", $grabProductPriceFromGridAddBundleProductToOrder, "Bundle product price in grid should be equal $738.00"); // stepKey: assertProductPriceInGridAddBundleProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddBundleProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddBundleProductToOrderWaitForPageLoad
		$I->comment("Exiting Action Group [addBundleProductToOrder] AddBundleProductToOrderAndCheckPriceInGridActionGroup");
		$I->comment("Entering Action Group [orderSelectFlatRateShippingMethod] OrderSelectFlatRateShippingActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocusOrderSelectFlatRateShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForJavascriptToFinishOrderSelectFlatRateShippingMethod
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethodsOrderSelectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: clickShippingMethodsOrderSelectFlatRateShippingMethodWaitForPageLoad
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingOptionsOrderSelectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: waitForShippingOptionsOrderSelectFlatRateShippingMethodWaitForPageLoad
		$I->selectOption("#s_method_flatrate_flatrate", "flatrate_flatrate"); // stepKey: checkFlatRateOrderSelectFlatRateShippingMethod
		$I->waitForPageLoad(30); // stepKey: checkFlatRateOrderSelectFlatRateShippingMethodWaitForPageLoad
		$I->comment("Exiting Action Group [orderSelectFlatRateShippingMethod] OrderSelectFlatRateShippingActionGroup");
		$I->comment("Entering Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->scrollTo("#submit_order_top_button"); // stepKey: scrollToSubmitButtonSubmitOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitButtonSubmitOrderWaitForPageLoad
		$I->click("#submit_order_top_button"); // stepKey: submitOrderSubmitOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSubmitOrder
		$I->see("You created the order."); // stepKey: seeSuccessMessageForOrderSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminSubmitOrderActionGroup");
		$I->comment("Entering Action Group [startInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceActionStartInvoice
		$I->waitForPageLoad(30); // stepKey: clickInvoiceActionStartInvoiceWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_invoice/new/order_id/"); // stepKey: seeNewInvoiceUrlStartInvoice
		$I->see("New Invoice", ".page-header h1.page-title"); // stepKey: seeNewInvoicePageTitleStartInvoice
		$I->comment("Exiting Action Group [startInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->comment("Entering Action Group [submitInvoice] SubmitInvoiceActionGroup");
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: clickSubmitInvoiceSubmitInvoice
		$I->waitForPageLoad(60); // stepKey: clickSubmitInvoiceSubmitInvoiceWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageAppearsSubmitInvoice
		$I->see("The invoice has been created.", "#messages div.message-success"); // stepKey: seeInvoiceCreateSuccessSubmitInvoice
		$grabOrderIdSubmitInvoice = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderIdSubmitInvoice
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/"); // stepKey: seeViewOrderPageInvoiceSubmitInvoice
		$I->comment("Exiting Action Group [submitInvoice] SubmitInvoiceActionGroup");
		$grabOrderId = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderId
		$I->comment("Entering Action Group [openOrder] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageOpenOrder
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenOrder
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersOpenOrder
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersOpenOrder
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$grabOrderId"); // stepKey: fillOrderIdFilterOpenOrder
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersOpenOrder
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersOpenOrderWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageOpenOrder
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersOpenOrder
		$I->comment("Exiting Action Group [openOrder] OpenOrderByIdActionGroup");
		$I->comment("Entering Action Group [fillCreditMemoRefund] AdminOpenAndFillCreditMemoRefundBundleWithQtyActionGroup");
		$I->comment("Click 'Credit Memo' button");
		$I->click("#order_creditmemo"); // stepKey: clickCreateCreditMemoFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: clickCreateCreditMemoFillCreditMemoRefundWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_creditmemo/new/order_id/"); // stepKey: seeNewCreditMemoPageFillCreditMemoRefund
		$I->see("New Memo", ".page-header h1.page-title"); // stepKey: seeNewMemoInPageTitleFillCreditMemoRefund
		$I->comment("Fill data from dataset: refund");
		$I->scrollTo("#creditmemo_item_container span.title"); // stepKey: scrollToItemsToRefundFillCreditMemoRefund
		$I->fillField(".order-creditmemo-tables tr:nth-child(3) td .qty-input", "0"); // stepKey: fillQtyToRefundItemOneFillCreditMemoRefund
		$I->fillField(".order-creditmemo-tables tr:nth-child(5) td .qty-input", "0"); // stepKey: fillQtyToRefundItemTwoFillCreditMemoRefund
		$I->fillField(".order-creditmemo-tables tr:nth-child(6) td .qty-input", "0"); // stepKey: fillQtyToRefundItemThreeFillCreditMemoRefund
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForActivateButtonFillCreditMemoRefund
		$I->conditionalClick(".order-creditmemo-tables tfoot button[data-ui-id='order-items-update-button']", ".order-creditmemo-tables tfoot button[data-ui-id='order-items-update-button'].disabled", false); // stepKey: clickUpdateButtonFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: clickUpdateButtonFillCreditMemoRefundWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForUpdateFillCreditMemoRefund
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[shipping_amount]']", "0"); // stepKey: fillShippingFillCreditMemoRefund
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[adjustment_positive]']", "10"); // stepKey: fillAdjustmentRefundFillCreditMemoRefund
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[adjustment_negative]']", "0"); // stepKey: fillAdjustmentFeeFillCreditMemoRefund
		$I->waitForElementVisible(".update-totals-button", 30); // stepKey: waitForUpdateTotalsButtonFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: waitForUpdateTotalsButtonFillCreditMemoRefundWaitForPageLoad
		$I->click(".update-totals-button"); // stepKey: clickUpdateTotalsFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: clickUpdateTotalsFillCreditMemoRefundWaitForPageLoad
		$I->checkOption(".order-totals-actions #send_email"); // stepKey: checkSendEmailCopyFillCreditMemoRefund
		$I->comment("Exiting Action Group [fillCreditMemoRefund] AdminOpenAndFillCreditMemoRefundBundleWithQtyActionGroup");
		$I->comment("Entering Action Group [submitCreditMemo] SubmitCreditMemoActionGroup");
		$grabOrderIdSubmitCreditMemo = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderIdSubmitCreditMemo
		$I->waitForElementVisible(".order-totals-actions button[data-ui-id='order-items-submit-button']:not(.disabled)", 30); // stepKey: waitButtonEnabledSubmitCreditMemo
		$I->waitForPageLoad(60); // stepKey: waitButtonEnabledSubmitCreditMemoWaitForPageLoad
		$I->click(".order-totals-actions button[data-ui-id='order-items-submit-button']:not(.disabled)"); // stepKey: clickSubmitCreditMemoSubmitCreditMemo
		$I->waitForPageLoad(60); // stepKey: clickSubmitCreditMemoSubmitCreditMemoWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageAppearsSubmitCreditMemo
		$I->see("You created the credit memo.", "#messages div.message-success"); // stepKey: seeCreditMemoCreateSuccessSubmitCreditMemo
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/$grabOrderIdSubmitCreditMemo"); // stepKey: seeViewOrderPageCreditMemoSubmitCreditMemo
		$I->comment("Exiting Action Group [submitCreditMemo] SubmitCreditMemoActionGroup");
		$I->comment("Entering Action Group [openCreditMemo] AdminOpenCreditMemoFromOrderPageActionGroup");
		$I->conditionalClick("#sales_order_view_tabs_order_creditmemos", "#sales_order_view_tabs_order_creditmemos_content .data-grid tbody > tr:nth-of-type(1) a[href*='order_creditmemo/view']", false); // stepKey: openCreditMemosTabOpenCreditMemo
		$I->waitForElementVisible("div#sales_order_view_tabs_order_creditmemos_content a.action-menu-item", 30); // stepKey: waitForCreditMemosTabOpenedOpenCreditMemo
		$I->click("#sales_order_view_tabs_order_creditmemos_content .data-grid tbody > tr:nth-of-type(1) a[href*='order_creditmemo/view']"); // stepKey: viewMemoOpenCreditMemo
		$I->waitForPageLoad(30); // stepKey: waitForCreditMemoOpenedOpenCreditMemo
		$I->comment("Exiting Action Group [openCreditMemo] AdminOpenCreditMemoFromOrderPageActionGroup");
		$I->scrollTo("//td[contains(text(), 'Subtotal')]/following-sibling::td//span[@class='price']"); // stepKey: scrollToTotal
		$I->comment("Entering Action Group [assertCreditMemoViewPageTotals] AssertAdminCreditMemoViewPageTotalsActionGroup");
		$I->see("$0.00", "//td[contains(text(), 'Subtotal')]/following-sibling::td//span[@class='price']"); // stepKey: seeSubtotalAssertCreditMemoViewPageTotals
		$I->see("$10.00", "//td[contains(text(), 'Adjustment Refund')]/following-sibling::td//span[@class='price']"); // stepKey: seeAdjustmentRefundAssertCreditMemoViewPageTotals
		$I->see("$0.00", "//td[contains(text(), 'Adjustment Fee')]/following-sibling::td//span[@class='price']"); // stepKey: seeAdjustmentFeeAssertCreditMemoViewPageTotals
		$I->see("$10.00", ".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: seeGrandTotalAssertCreditMemoViewPageTotals
		$I->comment("Exiting Action Group [assertCreditMemoViewPageTotals] AssertAdminCreditMemoViewPageTotalsActionGroup");
	}
}
