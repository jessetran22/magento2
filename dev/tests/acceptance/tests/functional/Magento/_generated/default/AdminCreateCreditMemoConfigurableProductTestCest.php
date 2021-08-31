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
 * @Title("MC-28444: Create Credit Memo for Offline Payment Methods")
 * @Description("Create CreditMemo return to stock only one unit of configurable product<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/AdminCreateCreditMemoConfigurableProductTest.xml<br>")
 * @TestCaseId("MC-28444")
 * @group sales
 * @group mtf_migrated
 */
class AdminCreateCreditMemoConfigurableProductTestCest
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
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->comment("Create the configurable product and add it to the category");
		$createConfigProductFields['price'] = "40";
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], $createConfigProductFields); // stepKey: createConfigProduct
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
		$createConfigChildProduct1Fields['price'] = "40";
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOneQty10", ["createConfigProductAttribute", "getConfigAttributeOption1"], $createConfigChildProduct1Fields); // stepKey: createConfigChildProduct1
		$createConfigChildProduct2Fields['price'] = "40";
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwoQty10", ["createConfigProductAttribute", "getConfigAttributeOption2"], $createConfigChildProduct2Fields); // stepKey: createConfigChildProduct2
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->comment("Add simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Enable payment method one of \"Check/Money Order\" and  shipping method one of \"Flat Rate\"");
		$enableCheckMoneyOrder = $I->magentoCLI("config:set payment/checkmo/active 1", 60); // stepKey: enableCheckMoneyOrder
		$I->comment($enableCheckMoneyOrder);
		$I->createEntity("enableFlatRate", "hook", "FlatRateShippingMethodConfig", [], []); // stepKey: enableFlatRate
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
		$I->comment("Delete data");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteApiCategory
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [clearProductGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearProductGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearProductGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearProductGridFilters] ClearFiltersAdminDataGridActionGroup");
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
	 * @Stories({"Credit memo entity"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCreditMemoConfigurableProductTest(AcceptanceTester $I)
	{
		$I->comment("Create Order");
		$I->comment("Entering Action Group [navigateToNewOrderPage] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadNavigateToNewOrderPage
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleNavigateToNewOrderPage
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderNavigateToNewOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadNavigateToNewOrderPage
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersNavigateToNewOrderPageWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailNavigateToNewOrderPage
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadNavigateToNewOrderPage
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadNavigateToNewOrderPage
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPage
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsNavigateToNewOrderPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectNavigateToNewOrderPage
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleNavigateToNewOrderPage
		$I->comment("Exiting Action Group [navigateToNewOrderPage] NavigateToNewOrderPageExistingCustomerActionGroup");
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
		$I->comment("Entering Action Group [fillCustomerInfo] FillOrderCustomerInformationActionGroup");
		$I->fillField("#order-billing_address_firstname", $I->retrieveEntityField('createCustomer', 'firstname', 'test')); // stepKey: fillFirstNameFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillFirstNameFillCustomerInfoWaitForPageLoad
		$I->fillField("#order-billing_address_lastname", $I->retrieveEntityField('createCustomer', 'lastname', 'test')); // stepKey: fillLastNameFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillLastNameFillCustomerInfoWaitForPageLoad
		$I->fillField("#order-billing_address_street0", "7700 West Parmer Lane"); // stepKey: fillStreetLine1FillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillStreetLine1FillCustomerInfoWaitForPageLoad
		$I->fillField("#order-billing_address_city", "Austin"); // stepKey: fillCityFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillCityFillCustomerInfoWaitForPageLoad
		$I->selectOption("#order-billing_address_country_id", "US"); // stepKey: fillCountryFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillCountryFillCustomerInfoWaitForPageLoad
		$I->selectOption("#order-billing_address_region_id", "Texas"); // stepKey: fillStateFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillStateFillCustomerInfoWaitForPageLoad
		$I->fillField("#order-billing_address_postcode", "78729"); // stepKey: fillPostalCodeFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillPostalCodeFillCustomerInfoWaitForPageLoad
		$I->fillField("#order-billing_address_telephone", "512-345-6789"); // stepKey: fillPhoneFillCustomerInfo
		$I->waitForPageLoad(30); // stepKey: fillPhoneFillCustomerInfoWaitForPageLoad
		$I->comment("Exiting Action Group [fillCustomerInfo] FillOrderCustomerInformationActionGroup");
		$I->comment("Entering Action Group [selectFlatRate] OrderSelectFlatRateShippingActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocusSelectFlatRate
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForJavascriptToFinishSelectFlatRate
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethodsSelectFlatRate
		$I->waitForPageLoad(30); // stepKey: clickShippingMethodsSelectFlatRateWaitForPageLoad
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingOptionsSelectFlatRate
		$I->waitForPageLoad(30); // stepKey: waitForShippingOptionsSelectFlatRateWaitForPageLoad
		$I->selectOption("#s_method_flatrate_flatrate", "flatrate_flatrate"); // stepKey: checkFlatRateSelectFlatRate
		$I->waitForPageLoad(30); // stepKey: checkFlatRateSelectFlatRateWaitForPageLoad
		$I->comment("Exiting Action Group [selectFlatRate] OrderSelectFlatRateShippingActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: submitOrder
		$I->waitForPageLoad(60); // stepKey: submitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSubmitOrderPage
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageForOrderAppears
		$I->see("You created the order.", "#messages div.message-success"); // stepKey: seeSuccessMessageForOrder
		$I->comment("Create Invoice");
		$I->comment("Entering Action Group [startInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceActionStartInvoice
		$I->waitForPageLoad(30); // stepKey: clickInvoiceActionStartInvoiceWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_invoice/new/order_id/"); // stepKey: seeNewInvoiceUrlStartInvoice
		$I->see("New Invoice", ".page-header h1.page-title"); // stepKey: seeNewInvoicePageTitleStartInvoice
		$I->comment("Exiting Action Group [startInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->comment("Entering Action Group [clickSubmitInvoice] SubmitInvoiceActionGroup");
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: clickSubmitInvoiceClickSubmitInvoice
		$I->waitForPageLoad(60); // stepKey: clickSubmitInvoiceClickSubmitInvoiceWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageAppearsClickSubmitInvoice
		$I->see("The invoice has been created.", "#messages div.message-success"); // stepKey: seeInvoiceCreateSuccessClickSubmitInvoice
		$grabOrderIdClickSubmitInvoice = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderIdClickSubmitInvoice
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/"); // stepKey: seeViewOrderPageInvoiceClickSubmitInvoice
		$I->comment("Exiting Action Group [clickSubmitInvoice] SubmitInvoiceActionGroup");
		$I->comment("Go to Sales > Orders > find out placed order and open");
		$I->comment("Entering Action Group [openOrder] AdminOpenOrderByEntityIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/{$grabOrderIdClickSubmitInvoice}"); // stepKey: openOrderOpenOrder
		$I->comment("Exiting Action Group [openOrder] AdminOpenOrderByEntityIdActionGroup");
		$I->comment("Click 'Credit Memo' button and fill data from dataset: partial refund");
		$I->comment("Entering Action Group [fillCreditMemoRefund] AdminOpenAndFillCreditMemoRefundAndBackToStockActionGroup");
		$I->comment("Click 'Credit Memo' button");
		$I->click("#order_creditmemo"); // stepKey: clickCreateCreditMemoFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: clickCreateCreditMemoFillCreditMemoRefundWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_creditmemo/new/order_id/"); // stepKey: seeNewCreditMemoPageFillCreditMemoRefund
		$I->see("New Memo", ".page-header h1.page-title"); // stepKey: seeNewMemoInPageTitleFillCreditMemoRefund
		$I->comment("Fill data from dataset: refund");
		$I->scrollTo("#creditmemo_item_container span.title"); // stepKey: scrollToItemsToRefundFillCreditMemoRefund
		$I->checkOption(".order-creditmemo-tables tbody:nth-of-type(1) .col-return-to-stock input"); // stepKey: backToStockFillCreditMemoRefund
		$I->fillField(".order-creditmemo-tables tbody:nth-of-type(1) .col-refund .qty-input", "1"); // stepKey: fillQtyToRefundFillCreditMemoRefund
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForActivateButtonFillCreditMemoRefund
		$I->conditionalClick(".order-creditmemo-tables tfoot button[data-ui-id='order-items-update-button']", ".order-creditmemo-tables tfoot button[data-ui-id='order-items-update-button'].disabled", false); // stepKey: clickUpdateButtonFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: clickUpdateButtonFillCreditMemoRefundWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForUpdateFillCreditMemoRefund
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[shipping_amount]']", "5"); // stepKey: fillShippingFillCreditMemoRefund
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[adjustment_positive]']", "0"); // stepKey: fillAdjustmentRefundFillCreditMemoRefund
		$I->fillField(".order-subtotal-table tbody input[name='creditmemo[adjustment_negative]']", "0"); // stepKey: fillAdjustmentFeeFillCreditMemoRefund
		$I->waitForElementVisible(".update-totals-button", 30); // stepKey: waitForUpdateTotalsButtonFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: waitForUpdateTotalsButtonFillCreditMemoRefundWaitForPageLoad
		$I->click(".update-totals-button"); // stepKey: clickUpdateTotalsFillCreditMemoRefund
		$I->waitForPageLoad(30); // stepKey: clickUpdateTotalsFillCreditMemoRefundWaitForPageLoad
		$I->checkOption(".order-totals-actions #send_email"); // stepKey: checkSendEmailCopyFillCreditMemoRefund
		$I->comment("Exiting Action Group [fillCreditMemoRefund] AdminOpenAndFillCreditMemoRefundAndBackToStockActionGroup");
		$I->comment("On order's page click 'Refund offline' button");
		$I->comment("Entering Action Group [clickRefundOffline] SubmitCreditMemoActionGroup");
		$grabOrderIdClickRefundOffline = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderIdClickRefundOffline
		$I->waitForElementVisible(".order-totals-actions button[data-ui-id='order-items-submit-button']:not(.disabled)", 30); // stepKey: waitButtonEnabledClickRefundOffline
		$I->waitForPageLoad(60); // stepKey: waitButtonEnabledClickRefundOfflineWaitForPageLoad
		$I->click(".order-totals-actions button[data-ui-id='order-items-submit-button']:not(.disabled)"); // stepKey: clickSubmitCreditMemoClickRefundOffline
		$I->waitForPageLoad(60); // stepKey: clickSubmitCreditMemoClickRefundOfflineWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageAppearsClickRefundOffline
		$I->see("You created the credit memo.", "#messages div.message-success"); // stepKey: seeCreditMemoCreateSuccessClickRefundOffline
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/$grabOrderIdClickRefundOffline"); // stepKey: seeViewOrderPageCreditMemoClickRefundOffline
		$I->comment("Exiting Action Group [clickRefundOffline] SubmitCreditMemoActionGroup");
		$I->comment("Assert product Qty decreased after CreditMemo");
		$I->comment("Entering Action Group [assertQtyDecreased] AdminAssertProductQtyInGridActionGroup");
		$I->comment("Assert product Qty decreased after CreditMemo");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: onProductPageAssertQtyDecreased
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAssertQtyDecreased
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersAssertQtyDecreased
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersAssertQtyDecreasedWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersAssertQtyDecreased
		$I->waitForPageLoad(30); // stepKey: waitForFilterAssertQtyDecreased
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createConfigChildProduct1', 'sku', 'test')); // stepKey: fillOrderIdFilterAssertQtyDecreased
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersAssertQtyDecreased
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersAssertQtyDecreasedWaitForPageLoad
		$I->see("10.000"); // stepKey: assertQtyDecreasedAssertQtyDecreased
		$I->comment("Exiting Action Group [assertQtyDecreased] AdminAssertProductQtyInGridActionGroup");
	}
}
