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
 * @Title("MC-16066: Cancel the created order with check/money order payment method")
 * @Description("Create an order with check/money order payment method and cancel the order<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCancelTheCreatedOrderWithCheckMoneyOrderPaymentMethodTest.xml<br>")
 * @TestCaseId("MC-16066")
 */
class AdminCancelTheCreatedOrderWithCheckMoneyOrderPaymentMethodTestCest
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
		$I->comment("Set default flat rate shipping method settings");
		$I->comment("Set default flat rate shipping method settings");
		$I->createEntity("setDefaultFlatRateShippingMethod", "hook", "FlatRateShippingMethodDefault", [], []); // stepKey: setDefaultFlatRateShippingMethod
		$I->comment("Create simple customer");
		$I->comment("Create simple customer");
		$I->createEntity("simpleCustomer", "hook", "Simple_US_Customer_CA", [], []); // stepKey: simpleCustomer
		$I->comment("Create the category");
		$I->comment("Create the category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Create Virtual Product");
		$I->comment("Create Virtual Product");
		$I->createEntity("virtualProduct", "hook", "VirtualProductPrice10Qty1", ["createCategory"], []); // stepKey: virtualProduct
		$I->comment("Create Simple Product");
		$I->comment("Create Simple Product");
		$I->createEntity("simpleProduct", "hook", "SimpleProductPrice10Qty1", ["createCategory"], []); // stepKey: simpleProduct
		$I->comment("Create Bundle product");
		$I->comment("Create Bundle Product");
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2Price10Qty1", [], []); // stepKey: simpleProduct1
		$I->createEntity("createBundleProduct", "hook", "BundleProductPriceViewRange", ["createCategory"], []); // stepKey: createBundleProduct
		$createBundleOption1_1Fields['required'] = "True";
		$I->createEntity("createBundleOption1_1", "hook", "DropDownBundleOption", ["createBundleProduct"], $createBundleOption1_1Fields); // stepKey: createBundleOption1_1
		$I->createEntity("linkOptionToProduct", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption1_1", "simpleProduct1"], []); // stepKey: linkOptionToProduct
		$I->comment("Create configurable product and add it to the category");
		$I->comment("Create configurable product and add it to the category");
		$I->createEntity("createConfigProduct", "hook", "ConfigurableProductPrice10Qty1", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Create an attribute with two options to be used in the first child product");
		$I->comment("Create an attribute with two options to be used in the first child product");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->comment("Add the attribute we just created to default attribute set");
		$I->comment("Add the attribute we just created to default attribute set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->comment("Get the option of the attribute we created");
		$I->comment("Get the option of the attribute we created");
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->comment("Create a simple product and give it the attribute with option");
		$I->comment("Create a simple product and give it the attribute with option");
		$I->createEntity("createConfigChildProduct1", "hook", "SimpleProduct3Price10Qty1", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->comment("Create the configurable product");
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigProductOption
		$I->comment("Add simple product to the configurable product");
		$I->comment("Add simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleCustomer", "hook"); // stepKey: deleteSimpleCustomer
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("virtualProduct", "hook"); // stepKey: deleteVirtualProduct
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigurableProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCancelTheCreatedOrderWithCheckMoneyOrderPaymentMethodTest(AcceptanceTester $I)
	{
		$I->comment("Create new customer order");
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
		$I->comment("Add bundle product to order and check product price in grid");
		$I->comment("Add bundle product to order and check product price in grid");
		$I->comment("Entering Action Group [addBundleProductToOrder] AddBundleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddBundleProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createBundleProduct', 'sku', 'test')); // stepKey: fillSkuFilterBundleAddBundleProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchBundleAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchBundleAddBundleProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddBundleProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectBundleProductAddBundleProductToOrder
		$I->waitForElementVisible("#product_composite_configure_input_qty", 30); // stepKey: waitForBundleOptionLoadAddBundleProductToOrder
		$I->wait(2); // stepKey: waitForOptionsToLoadAddBundleProductToOrder
		$I->fillField("#product_composite_configure_input_qty", "1"); // stepKey: fillQuantityAddBundleProductToOrder
		$I->click(".modal-header .page-actions button[data-role='action']"); // stepKey: clickOkAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickOkAddBundleProductToOrderWaitForPageLoad
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddBundleProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddBundleProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddBundleProductToOrderWaitForPageLoad
		$I->comment("Exiting Action Group [addBundleProductToOrder] AddBundleProductToOrderActionGroup");
		$I->comment("Add configurable product to order");
		$I->comment("Add configurable product to order");
		$I->comment("Entering Action Group [addConfigurableProductToOrder] NewAddConfigurableProductToOrderActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageAddConfigurableProductToOrder
		$I->waitForElementVisible("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']", 30); // stepKey: waitForAddProductsButtonAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: waitForAddProductsButtonAddConfigurableProductToOrderWaitForPageLoad
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddConfigurableProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createConfigProduct', 'sku', 'test')); // stepKey: fillSkuFilterConfigurableAddConfigurableProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchConfigurableAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchConfigurableAddConfigurableProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddConfigurableProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectConfigurableProductAddConfigurableProductToOrder
		$I->wait(2); // stepKey: waitForOptionsToLoadAddConfigurableProductToOrder
		$I->selectOption("//form[@id='product_composite_configure_form']//select", $I->retrieveEntityField('getConfigAttributeOption1', 'value', 'test')); // stepKey: selectOptionAddConfigurableProductToOrder
		$I->click(".modal-header .page-actions button[data-role='action']"); // stepKey: clickOkConfigurablePopoverAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickOkConfigurablePopoverAddConfigurableProductToOrderWaitForPageLoad
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddConfigurableProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddConfigurableProductToOrderWaitForPageLoad
		$I->comment("Exiting Action Group [addConfigurableProductToOrder] NewAddConfigurableProductToOrderActionGroup");
		$I->comment("Add Simple product to order");
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
		$I->comment("Add Virtual product to order");
		$I->comment("Add Virtual product to order");
		$I->comment("Entering Action Group [addVirtualProductToTheOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddVirtualProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddVirtualProductToTheOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('virtualProduct', 'sku', 'test')); // stepKey: fillSkuFilterAddVirtualProductToTheOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddVirtualProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddVirtualProductToTheOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddVirtualProductToTheOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddVirtualProductToTheOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddVirtualProductToTheOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddVirtualProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddVirtualProductToTheOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddVirtualProductToTheOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddVirtualProductToTheOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddVirtualProductToTheOrder
		$I->comment("Exiting Action Group [addVirtualProductToTheOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Select FlatRate shipping method");
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
		$I->comment("Submit order");
		$I->comment("Submit order");
		$I->comment("Entering Action Group [submitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderSubmitOrder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadSubmitOrder
		$I->comment("Exiting Action Group [submitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->comment("Verify order information");
		$I->comment("Verify order information");
		$I->comment("Entering Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
		$I->see("You created the order.", "div.message-success"); // stepKey: seeSuccessMessageVerifyCreatedOrderInformation
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderPendingStatusVerifyCreatedOrderInformation
		$getOrderIdVerifyCreatedOrderInformation = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: getOrderIdVerifyCreatedOrderInformation
		$I->assertNotEmpty($getOrderIdVerifyCreatedOrderInformation); // stepKey: assertOrderIdIsNotEmptyVerifyCreatedOrderInformation
		$I->comment("Exiting Action Group [verifyCreatedOrderInformation] VerifyCreatedOrderInformationActionGroup");
		$orderId = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: orderId
		$I->comment("Cancel the Order");
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
		$I->comment("Assert Simple Product Quantity in backend after order Canceled");
		$I->comment("Assert Simple Product Quantity in backend after order Canceled");
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
		$I->seeInField(".admin__field[data-index=qty] input", "1"); // stepKey: seeProductQuantity
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatus
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusWaitForPageLoad
		$I->comment("Assert Simple Product Stock Status in frontend after order canceled");
		$I->comment("Assert Simple Product Stock Status in frontend after order Canceled");
		$I->comment("Entering Action Group [checkProductQtyOfSimpleProduct] StorefrontCheckProductStockStatus");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageCheckProductQtyOfSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCheckProductQtyOfSimpleProduct
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameCheckProductQtyOfSimpleProduct
		$I->see("IN STOCK"); // stepKey: assertProductStockStatusCheckProductQtyOfSimpleProduct
		$I->comment("Exiting Action Group [checkProductQtyOfSimpleProduct] StorefrontCheckProductStockStatus");
		$I->comment("Assert Virtual Product Quantity in backend after order canceled");
		$I->comment("Assert Virtual Product Quantity in backend after order canceled");
		$I->comment("Entering Action Group [filterAndSelectTheVirtualProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterAndSelectTheVirtualProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterAndSelectTheVirtualProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterAndSelectTheVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterAndSelectTheVirtualProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterAndSelectTheVirtualProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('virtualProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterAndSelectTheVirtualProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterAndSelectTheVirtualProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterAndSelectTheVirtualProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterAndSelectTheVirtualProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('virtualProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductFilterAndSelectTheVirtualProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterAndSelectTheVirtualProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterAndSelectTheVirtualProduct
		$I->comment("Exiting Action Group [filterAndSelectTheVirtualProduct] FilterAndSelectProductActionGroup");
		$I->waitForElementVisible(".admin__field[data-index=name] input", 30); // stepKey: waitForProductDetailsToLoad1
		$I->seeInField(".admin__field[data-index=name] input", $I->retrieveEntityField('virtualProduct', 'name', 'test')); // stepKey: seeVirtualProductName
		$I->seeInField(".admin__field[data-index=qty] input", "1"); // stepKey: seeVirtualProductQuantity
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeVirtualProductStockStatus
		$I->waitForPageLoad(30); // stepKey: seeVirtualProductStockStatusWaitForPageLoad
		$I->comment("Assert Virtual Product Stock Status in frontend after order canceled");
		$I->comment("Assert Virtual Product Stock Status in frontend after order Canceled");
		$I->comment("Entering Action Group [checkProductQtyOfVirtualProduct] StorefrontCheckProductStockStatus");
		$I->amOnPage("/" . $I->retrieveEntityField('virtualProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageCheckProductQtyOfVirtualProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCheckProductQtyOfVirtualProduct
		$I->see($I->retrieveEntityField('virtualProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameCheckProductQtyOfVirtualProduct
		$I->see("IN STOCK"); // stepKey: assertProductStockStatusCheckProductQtyOfVirtualProduct
		$I->comment("Exiting Action Group [checkProductQtyOfVirtualProduct] StorefrontCheckProductStockStatus");
		$I->comment("Assert Bundle Product Quantity in backend after order canceled");
		$I->comment("Assert Bundle Product Quantity in backend after order canceled");
		$I->comment("Entering Action Group [filterAndSelectTheBundleProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterAndSelectTheBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterAndSelectTheBundleProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterAndSelectTheBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterAndSelectTheBundleProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterAndSelectTheBundleProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterAndSelectTheBundleProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterAndSelectTheBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterAndSelectTheBundleProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterAndSelectTheBundleProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('simpleProduct1', 'sku', 'test') . "']]"); // stepKey: openSelectedProductFilterAndSelectTheBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterAndSelectTheBundleProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterAndSelectTheBundleProduct
		$I->comment("Exiting Action Group [filterAndSelectTheBundleProduct] FilterAndSelectProductActionGroup");
		$I->waitForElementVisible(".admin__field[data-index=name] input", 30); // stepKey: waitForProductDetailsToLoad2
		$I->seeInField(".admin__field[data-index=name] input", $I->retrieveEntityField('simpleProduct1', 'name', 'test')); // stepKey: seeBundleProductName
		$I->seeInField(".admin__field[data-index=qty] input", "1"); // stepKey: seeBundleProductQuantity
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeBundleProductStockStatus
		$I->waitForPageLoad(30); // stepKey: seeBundleProductStockStatusWaitForPageLoad
		$I->comment("Assert Bundle Product Stock Status in frontend after order canceled");
		$I->comment("Assert Bundle Product Stock Status in frontend after order Canceled");
		$I->comment("Entering Action Group [checkProductQtyOfBundleProduct] StorefrontCheckProductStockStatus");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageCheckProductQtyOfBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCheckProductQtyOfBundleProduct
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameCheckProductQtyOfBundleProduct
		$I->see("IN STOCK"); // stepKey: assertProductStockStatusCheckProductQtyOfBundleProduct
		$I->comment("Exiting Action Group [checkProductQtyOfBundleProduct] StorefrontCheckProductStockStatus");
		$I->comment("Assert Configurable Product Quantity in backend after order canceled");
		$I->comment("Assert Configurable Product quantity in backend after order canceled");
		$I->comment("Entering Action Group [filterAndSelectTheConfigProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterAndSelectTheConfigProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterAndSelectTheConfigProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterAndSelectTheConfigProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterAndSelectTheConfigProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterAndSelectTheConfigProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigChildProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilterFilterAndSelectTheConfigProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterAndSelectTheConfigProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterAndSelectTheConfigProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterAndSelectTheConfigProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createConfigChildProduct1', 'sku', 'test') . "']]"); // stepKey: openSelectedProductFilterAndSelectTheConfigProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterAndSelectTheConfigProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterAndSelectTheConfigProduct
		$I->comment("Exiting Action Group [filterAndSelectTheConfigProduct] FilterAndSelectProductActionGroup");
		$I->waitForElementVisible(".admin__field[data-index=name] input", 30); // stepKey: waitForProductDetailsToLoad3
		$I->seeInField(".admin__field[data-index=name] input", $I->retrieveEntityField('createConfigChildProduct1', 'name', 'test')); // stepKey: seeConfigProductName
		$I->seeInField(".admin__field[data-index=qty] input", "1"); // stepKey: seeConfigProductQuantity
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeConfigProductStockStatus
		$I->waitForPageLoad(30); // stepKey: seeConfigProductStockStatusWaitForPageLoad
		$I->comment("Assert Configurable Product Stock Status in frontend after order canceled");
		$I->comment("Assert Configurable Product Stock Status in frontend after order Canceled");
		$I->comment("Entering Action Group [checkProductQtyOfConfigProductInFrontend] StorefrontCheckProductStockStatus");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageCheckProductQtyOfConfigProductInFrontend
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCheckProductQtyOfConfigProductInFrontend
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".base"); // stepKey: seeProductNameCheckProductQtyOfConfigProductInFrontend
		$I->see("IN STOCK"); // stepKey: assertProductStockStatusCheckProductQtyOfConfigProductInFrontend
		$I->comment("Exiting Action Group [checkProductQtyOfConfigProductInFrontend] StorefrontCheckProductStockStatus");
		$I->comment("Open Order Index Page");
		$I->comment("Open Order Index Page");
		$I->comment("Entering Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToOrders
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToOrders
		$I->comment("Exiting Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->comment("Filter order using orderId");
		$I->comment("Filter order using orderId");
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
		$I->see("$orderId", "tr.data-row:nth-of-type(1)"); // stepKey: seeOrderIdInGrid
		$I->see("Canceled", "tr.data-row:nth-of-type(1)"); // stepKey: seeStatusInGrid
		$I->comment("Log in to Storefront as Customer");
		$I->comment("Log in to Storefront as Customer");
		$I->comment("Entering Action Group [signUp] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageSignUp
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedSignUp
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsSignUp
		$I->fillField("#email", $I->retrieveEntityField('simpleCustomer', 'email', 'test')); // stepKey: fillEmailSignUp
		$I->fillField("#pass", $I->retrieveEntityField('simpleCustomer', 'password', 'test')); // stepKey: fillPasswordSignUp
		$I->click("#send2"); // stepKey: clickSignInAccountButtonSignUp
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonSignUpWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInSignUp
		$I->comment("Exiting Action Group [signUp] LoginToStorefrontActionGroup");
		$I->comment("Assert Order status in frontend order grid");
		$I->comment("Assert Order status in frontend order grid ");
		$I->click("//div[@id='block-collapsible-nav']//*[contains(text(), 'My Orders')]"); // stepKey: clickOnMyOrders
		$I->waitForPageLoad(30); // stepKey: waitForOrderDetailsToLoad
		$I->seeElement("//td[contains(.,'$orderId')]/../td[contains(.,'Canceled')]"); // stepKey: seeOrderStatusInGrid
	}
}
