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
 * @group Sales
 * @group mtf_migrated
 * @Title("MC-16071: Cancel the created order with product quantity without stock decrease")
 * @Description("Create an order with product quantity without stock decrease, cancel the order and verify product quantity in backend<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCancelTheCreatedOrderWithProductQtyWithoutStockDecreaseTest.xml<br>")
 * @TestCaseId("MC-16071")
 */
class AdminCancelTheCreatedOrderWithProductQtyWithoutStockDecreaseTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$disableDecreaseInQuantityAfterOrder = $I->magentoCLI("config:set cataloginventory/options/can_subtract 0", 60); // stepKey: disableDecreaseInQuantityAfterOrder
		$I->comment($disableDecreaseInQuantityAfterOrder);
		$I->comment("Set default flat rate shipping method settings");
		$I->createEntity("setDefaultFlatRateShippingMethod", "hook", "FlatRateShippingMethodDefault", [], []); // stepKey: setDefaultFlatRateShippingMethod
		$I->comment("Create simple customer");
		$I->createEntity("simpleCustomer", "hook", "Simple_US_Customer_CA", [], []); // stepKey: simpleCustomer
		$I->comment("Create the category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Create Simple Product");
		$simpleProductFields['price'] = "10.00";
		$I->createEntity("simpleProduct", "hook", "ApiSimplePrice10Qty10", ["createCategory"], $simpleProductFields); // stepKey: simpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$enableDecreaseInQuantityAfterOrder = $I->magentoCLI("config:set cataloginventory/options/can_subtract 1", 60); // stepKey: enableDecreaseInQuantityAfterOrder
		$I->comment($enableDecreaseInQuantityAfterOrder);
		$I->deleteEntity("simpleCustomer", "hook"); // stepKey: deleteSimpleCustomer
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Cancel Created Order"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCancelTheCreatedOrderWithProductQtyWithoutStockDecreaseTest(AcceptanceTester $I)
	{
		$I->comment("Create new customer order");
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
		$I->comment("Add Simple product to order");
		$I->comment("Entering Action Group [addSimpleProductToTheOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSimpleProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSimpleProductToTheOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddSimpleProductToTheOrder
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
		$I->comment("Select FlatRate shipping method");
		$I->comment("Entering Action Group [selectFlatRateShippingMethod] AdminSelectFlatRateShippingMethodActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSelectFlatRateShippingMethod
		$I->click("//span[text()='Get shipping methods and rates']"); // stepKey: openShippingMethodSelectFlatRateShippingMethod
		$I->waitForPageLoad(60); // stepKey: openShippingMethodSelectFlatRateShippingMethodWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingMethodsSelectFlatRateShippingMethod
		$I->click("//label[contains(text(), 'Fixed')]"); // stepKey: chooseShippingMethodSelectFlatRateShippingMethod
		$I->waitForPageLoad(60); // stepKey: chooseShippingMethodSelectFlatRateShippingMethodWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectFlatRateShippingMethod
		$I->comment("Exiting Action Group [selectFlatRateShippingMethod] AdminSelectFlatRateShippingMethodActionGroup");
		$I->comment("Entering Action Group [submitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderSubmitOrder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->comment("Verify order information");
		$I->comment("Entering Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
		$I->see("You created the order.", "div.message-success"); // stepKey: seeSuccessMessageVerifyCreatedOrderInformation
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderPendingStatusVerifyCreatedOrderInformation
		$getOrderIdVerifyCreatedOrderInformation = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: getOrderIdVerifyCreatedOrderInformation
		$I->assertNotEmpty($getOrderIdVerifyCreatedOrderInformation); // stepKey: assertOrderIdIsNotEmptyVerifyCreatedOrderInformation
		$I->comment("Exiting Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
		$orderId = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: orderId
		$I->comment("Assert Simple Product Quantity in backend after order");
		$I->comment("Entering Action Group [filterAndSelectTheProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterAndSelectTheProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterAndSelectTheProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterAndSelectTheProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterAndSelectTheProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterAndSelectTheProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterAndSelectTheProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterAndSelectTheProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterAndSelectTheProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterAndSelectTheProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('simpleProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductFilterAndSelectTheProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterAndSelectTheProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterAndSelectTheProduct
		$I->comment("Exiting Action Group [filterAndSelectTheProduct] FilterAndSelectProductActionGroup");
		$I->waitForElementVisible(".admin__field[data-index=name] input", 30); // stepKey: waitForProductDetailsToLoad
		$I->seeInField(".admin__field[data-index=name] input", $I->retrieveEntityField('simpleProduct', 'name', 'test')); // stepKey: seeProductName
		$I->seeInField(".admin__field[data-index=qty] input", "10"); // stepKey: seeProductQuantity
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatus
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusWaitForPageLoad
		$I->comment("Open Order Index Page");
		$I->comment("Entering Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToOrders
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToOrders
		$I->comment("Exiting Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->comment("Filter Order using orderId");
		$I->comment("Entering Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$orderId"); // stepKey: fillOrderIdFilterFilterOrderGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridById
		$I->comment("Exiting Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->click(".data-grid tbody > tr:nth-of-type(1) .action-menu-item"); // stepKey: clickOnViewAction
		$I->waitForPageLoad(30); // stepKey: clickOnViewActionWaitForPageLoad
		$I->comment("Cancel the Order");
		$I->comment("Entering Action Group [cancelPendingOrder] CancelPendingOrderActionGroup");
		$I->click("#order-view-cancel-button"); // stepKey: clickCancelOrderCancelPendingOrder
		$I->waitForPageLoad(30); // stepKey: clickCancelOrderCancelPendingOrderWaitForPageLoad
		$I->waitForElement("aside.confirm .modal-content", 30); // stepKey: waitForCancelConfirmationCancelPendingOrder
		$I->see("Are you sure you want to cancel this order?", "aside.confirm .modal-content"); // stepKey: seeConfirmationMessageCancelPendingOrder
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmOrderCancelCancelPendingOrder
		$I->waitForPageLoad(60); // stepKey: confirmOrderCancelCancelPendingOrderWaitForPageLoad
		$I->see("You canceled the order.", "#messages div.message-success"); // stepKey: seeCancelSuccessMessageCancelPendingOrder
		$I->see("Canceled", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatusCanceledCancelPendingOrder
		$I->comment("Exiting Action Group [cancelPendingOrder] CancelPendingOrderActionGroup");
		$I->comment("Assert Simple Product Quantity in backend after Cancelling the order");
		$I->comment("Entering Action Group [filterAndSelectTheProduct1] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterAndSelectTheProduct1
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterAndSelectTheProduct1
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterAndSelectTheProduct1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterAndSelectTheProduct1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterAndSelectTheProduct1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterAndSelectTheProduct1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterAndSelectTheProduct1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterAndSelectTheProduct1WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterAndSelectTheProduct1
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('simpleProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductFilterAndSelectTheProduct1
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterAndSelectTheProduct1
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterAndSelectTheProduct1
		$I->comment("Exiting Action Group [filterAndSelectTheProduct1] FilterAndSelectProductActionGroup");
		$I->waitForElementVisible(".admin__field[data-index=name] input", 30); // stepKey: waitForProductDetailsToLoad1
		$I->seeInField(".admin__field[data-index=name] input", $I->retrieveEntityField('simpleProduct', 'name', 'test')); // stepKey: seeProductName1
		$I->seeInField(".admin__field[data-index=qty] input", "10"); // stepKey: seeProductQuantityAfterCancelOrder
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAfterCancelOrder
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAfterCancelOrderWaitForPageLoad
		$I->comment("Open Order Index Page");
		$I->comment("Entering Action Group [goToOrders1] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToOrders1
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToOrders1
		$I->comment("Exiting Action Group [goToOrders1] AdminOrdersPageOpenActionGroup");
		$I->comment("Filter Order using orderId");
		$I->comment("Entering Action Group [filterOrderGridById1] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridById1
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridById1
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridById1
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridById1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridById1
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridById1
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridById1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridById1
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$orderId"); // stepKey: fillOrderIdFilterFilterOrderGridById1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridById1
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridById1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridById1
		$I->comment("Exiting Action Group [filterOrderGridById1] FilterOrderGridByIdActionGroup");
		$I->click(".data-grid tbody > tr:nth-of-type(1) .action-menu-item"); // stepKey: clickOnViewAction1
		$I->waitForPageLoad(30); // stepKey: clickOnViewAction1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoad
		$I->comment("Reorder the product");
		$I->click("#order_reorder"); // stepKey: clickOnReorderButton
		$I->waitForPageLoad(30); // stepKey: clickOnReorderButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForReorderFormToLoad
		$I->comment("Entering Action Group [submitOrder1] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderSubmitOrder1
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderSubmitOrder1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSubmitOrder1
		$I->comment("Exiting Action Group [submitOrder1] AdminOrderClickSubmitOrderActionGroup");
		$I->comment("Assert Simple Product Quantity in backend after Reorder");
		$I->comment("Entering Action Group [filterAndSelectTheProduct2] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterAndSelectTheProduct2
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterAndSelectTheProduct2
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterAndSelectTheProduct2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterAndSelectTheProduct2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterAndSelectTheProduct2
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterAndSelectTheProduct2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterAndSelectTheProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterAndSelectTheProduct2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterAndSelectTheProduct2
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('simpleProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductFilterAndSelectTheProduct2
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterAndSelectTheProduct2
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterAndSelectTheProduct2
		$I->comment("Exiting Action Group [filterAndSelectTheProduct2] FilterAndSelectProductActionGroup");
		$I->waitForElementVisible(".admin__field[data-index=name] input", 30); // stepKey: waitForProductDetailsToLoad2
		$I->seeInField(".admin__field[data-index=name] input", $I->retrieveEntityField('simpleProduct', 'name', 'test')); // stepKey: seeProductName2
		$I->seeInField(".admin__field[data-index=qty] input", "10"); // stepKey: seeProductQuantityAfterReorder
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAfterReorder
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAfterReorderWaitForPageLoad
	}
}
