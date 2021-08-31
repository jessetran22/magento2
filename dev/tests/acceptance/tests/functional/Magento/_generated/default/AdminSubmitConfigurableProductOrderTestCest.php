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
 * @Title("MC-26545: Create Order in Admin and update product configuration")
 * @Description("Create Order as admin and update product attribute configuration during order creation<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminSubmitConfigurableProductOrderTest.xml<br>")
 * @TestCaseId("MC-26545")
 * @group sales
 */
class AdminSubmitConfigurableProductOrderTestCest
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
		$I->comment("Set default flat rate shipping method settings");
		$I->createEntity("setDefaultFlatRateShippingMethod", "hook", "FlatRateShippingMethodDefault", [], []); // stepKey: setDefaultFlatRateShippingMethod
		$I->comment("Create simple customer");
		$I->createEntity("simpleCustomer", "hook", "Simple_US_Customer_CA", [], []); // stepKey: simpleCustomer
		$I->comment("Create the category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Create the configurable product and add it to the category");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Create an attribute with two options to be used in the first child product");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->comment("Add the attribute we just created to default attribute set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->comment("Get the option of the attribute we created");
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Create a simple product and give it the attribute with option");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->comment("Add simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
		$I->deleteEntity("simpleCustomer", "hook"); // stepKey: deleteSimpleCustomer
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteApiCategory
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
	 * @Features({"Sales"})
	 * @Stories({"Admin create order"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSubmitConfigurableProductOrderTest(AcceptanceTester $I)
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
		$I->comment("Add configurable product to order");
		$I->comment("Entering Action Group [addConfigurableProductToOrder] AddConfigurableProductToOrderFromAdminActionGroup");
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
		$I->waitForElementVisible("//div[contains(@class,'product-options')]//select[//label[text() = '" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']]", 30); // stepKey: waitForConfigurablePopoverAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: waitForConfigurablePopoverAddConfigurableProductToOrderWaitForPageLoad
		$I->wait(2); // stepKey: waitForOptionsToLoadAddConfigurableProductToOrder
		$I->selectOption("//div[contains(@class,'product-options')]//select[//label[text() = '" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']]", $I->retrieveEntityField('getConfigAttributeOption1', 'label', 'test')); // stepKey: selectionConfigurableOptionAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: selectionConfigurableOptionAddConfigurableProductToOrderWaitForPageLoad
		$I->click(".modal-header .page-actions button[data-role='action']"); // stepKey: clickOkConfigurablePopoverAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickOkConfigurablePopoverAddConfigurableProductToOrderWaitForPageLoad
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddConfigurableProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddConfigurableProductToOrderWaitForPageLoad
		$I->comment("Exiting Action Group [addConfigurableProductToOrder] AddConfigurableProductToOrderFromAdminActionGroup");
		$I->comment("Configure ordered configurable product");
		$I->comment("Entering Action Group [configureOrderedConfigurableProduct] ConfigureOrderedConfigurableProductActionGroup");
		$I->click(".product-configure-block button.action-default.scalable"); // stepKey: clickConfigureConfigureOrderedConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickConfigureConfigureOrderedConfigurableProductWaitForPageLoad
		$I->waitForElementVisible("//div[contains(@class,'product-options')]//select[//label[text() = '" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']]", 30); // stepKey: waitForConfigurablePopoverConfigureOrderedConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForConfigurablePopoverConfigureOrderedConfigurableProductWaitForPageLoad
		$I->wait(2); // stepKey: waitForOptionsToLoadConfigureOrderedConfigurableProduct
		$I->selectOption("//div[contains(@class,'product-options')]//select[//label[text() = '" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']]", $I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test')); // stepKey: selectionConfigurableOptionConfigureOrderedConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: selectionConfigurableOptionConfigureOrderedConfigurableProductWaitForPageLoad
		$I->fillField("#product_composite_configure_input_qty", "2"); // stepKey: fillQuantityConfigureOrderedConfigurableProduct
		$I->click(".modal-header .page-actions button[data-role='action']"); // stepKey: clickOkConfigurablePopoverConfigureOrderedConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickOkConfigurablePopoverConfigureOrderedConfigurableProductWaitForPageLoad
		$I->comment("Exiting Action Group [configureOrderedConfigurableProduct] ConfigureOrderedConfigurableProductActionGroup");
		$I->comment("Select FlatRate shipping method");
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
		$I->comment("Checkout select Check/Money Order payment");
		$I->comment("Entering Action Group [selectCheckMoneyPayment] SelectCheckMoneyPaymentMethodActionGroup");
		$I->waitForElementVisible("#order-billing_method", 30); // stepKey: waitForPaymentOptionsSelectCheckMoneyPayment
		$I->conditionalClick("#p_method_checkmo", "#p_method_checkmo", true); // stepKey: checkCheckMoneyOptionSelectCheckMoneyPayment
		$I->waitForPageLoad(30); // stepKey: checkCheckMoneyOptionSelectCheckMoneyPaymentWaitForPageLoad
		$I->comment("Exiting Action Group [selectCheckMoneyPayment] SelectCheckMoneyPaymentMethodActionGroup");
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
	}
}
