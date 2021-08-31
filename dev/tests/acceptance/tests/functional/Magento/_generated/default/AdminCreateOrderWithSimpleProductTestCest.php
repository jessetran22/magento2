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
 * @Title("MC-22110: Create Order in Admin with simple product")
 * @Description("Create order with simple product and assert if it gets out of stock after ordering it.<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateOrderWithSimpleProductTest.xml<br>")
 * @TestCaseId("MC-22110")
 * @group Sales
 * @group mtf_migrated
 */
class AdminCreateOrderWithSimpleProductTestCest
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
		$I->createEntity("cashOnDeliveryPaymentMethod", "hook", "CashOnDeliveryPaymentMethodDefault", [], []); // stepKey: cashOnDeliveryPaymentMethod
		$I->createEntity("simpleCustomer", "hook", "Simple_US_Customer_CA", [], []); // stepKey: simpleCustomer
		$simpleProductFields['price'] = "5";
		$I->createEntity("simpleProduct", "hook", "SimpleProduct_25", [], $simpleProductFields); // stepKey: simpleProduct
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
		$disableCashOnDeliveryMethod = $I->magentoCLI("config:set payment/cashondelivery/active 0", 60); // stepKey: disableCashOnDeliveryMethod
		$I->comment($disableCashOnDeliveryMethod);
		$I->deleteEntity("simpleCustomer", "hook"); // stepKey: deleteSimpleCustomer
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
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
	 * @Stories({"MAGETWO-12798: Create order with condition available product qty = ordered product qty"})
	 * @Features({"Sales"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateOrderWithSimpleProductTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddSimpleProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('simpleProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddSimpleProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddSimpleProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddSimpleProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddSimpleProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "25"); // stepKey: fillProductQtyAddSimpleProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddSimpleProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddSimpleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddSimpleProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddSimpleProductToOrder
		$I->comment("Exiting Action Group [addSimpleProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Entering Action Group [selectPaymentMethod] SelectCashOnDeliveryPaymentMethodActionGroup");
		$I->waitForElementVisible("#order-billing_method", 30); // stepKey: waitForPaymentOptionsSelectPaymentMethod
		$I->conditionalClick("#p_method_cashondelivery", "#p_method_cashondelivery", true); // stepKey: checkCashOnDeliveryOptionSelectPaymentMethod
		$I->waitForPageLoad(30); // stepKey: checkCashOnDeliveryOptionSelectPaymentMethodWaitForPageLoad
		$I->comment("Exiting Action Group [selectPaymentMethod] SelectCashOnDeliveryPaymentMethodActionGroup");
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
		$I->comment("Entering Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
		$I->see("You created the order.", "div.message-success"); // stepKey: seeSuccessMessageVerifyCreatedOrderInformation
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderPendingStatusVerifyCreatedOrderInformation
		$getOrderIdVerifyCreatedOrderInformation = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: getOrderIdVerifyCreatedOrderInformation
		$I->assertNotEmpty($getOrderIdVerifyCreatedOrderInformation); // stepKey: assertOrderIdIsNotEmptyVerifyCreatedOrderInformation
		$I->comment("Exiting Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
		$getOrderId = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: getOrderId
		$I->comment("Entering Action Group [openOrder] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageOpenOrder
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenOrder
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersOpenOrder
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersOpenOrder
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$getOrderId"); // stepKey: fillOrderIdFilterOpenOrder
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersOpenOrder
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersOpenOrderWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageOpenOrder
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersOpenOrder
		$I->comment("Exiting Action Group [openOrder] OpenOrderByIdActionGroup");
		$I->click("#order_ship"); // stepKey: clickShipAction
		$I->waitForPageLoad(30); // stepKey: clickShipActionWaitForPageLoad
		$I->click("button.action-default.save.submit-button"); // stepKey: clickSubmitShipment
		$I->waitForPageLoad(60); // stepKey: clickSubmitShipmentWaitForPageLoad
		$I->comment("Entering Action Group [checkProductStockStatus] AssertAdminProductStockStatusActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('simpleProduct', 'id', 'test')); // stepKey: goToProductEditPageCheckProductStockStatus
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCheckProductStockStatus
		$I->seeOptionIsSelected("select[name='product[quantity_and_stock_status][is_in_stock]']", "Out of Stock"); // stepKey: checkProductStatusCheckProductStockStatus
		$I->waitForPageLoad(30); // stepKey: checkProductStatusCheckProductStockStatusWaitForPageLoad
		$I->comment("Exiting Action Group [checkProductStockStatus] AssertAdminProductStockStatusActionGroup");
	}
}
