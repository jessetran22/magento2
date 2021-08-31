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
 * @Title("MC-13331: Create Partial Shipment for Offline Payment Methods")
 * @Description("Admin Should be Able to Create Partial Shipments<h3>Test files</h3>app/code/Magento/Shipping/Test/Mftf/Test/AdminCreatePartialShipmentEntityTest.xml<br>")
 * @TestCaseId("MC-13331")
 * @group sales
 * @group mtf_migrated
 */
class AdminCreatePartialShipmentEntityTestCest
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
		$I->comment("Create Data");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->comment("Enable payment method one of \"Check/Money Order\" and  shipping method one of \"Free Shipping\"");
		$enableCheckMoneyOrder = $I->magentoCLI("config:set payment/checkmo/active 1", 60); // stepKey: enableCheckMoneyOrder
		$I->comment($enableCheckMoneyOrder);
		$I->createEntity("enableFreeShipping", "hook", "FreeShippinMethodConfig", [], []); // stepKey: enableFreeShipping
		$I->comment("Entering Action Group [cleanCache] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanCache = $I->magentoCLI("cache:clean", 60, "config"); // stepKey: cleanSpecifiedCacheCleanCache
		$I->comment($cleanSpecifiedCacheCleanCache);
		$I->comment("Exiting Action Group [cleanCache] CliCacheCleanActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete data");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteProduct
		$I->createEntity("disableFreeShippingMethod", "hook", "FreeShippinMethodDefault", [], []); // stepKey: disableFreeShippingMethod
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
	 * @Stories({"Create Partial Shipment Entity"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Shipping"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreatePartialShipmentEntityTest(AcceptanceTester $I)
	{
		$I->comment("TEST BODY");
		$I->comment("Create Order");
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
		$I->comment("Entering Action Group [addProductToOrder] AddSimpleProductToOrderActionGroup");
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
		$I->comment("Exiting Action Group [addProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Select Free shipping");
		$I->comment("Entering Action Group [selectFreeShippingOption] OrderSelectFreeShippingActionGroup");
		$I->click("#order-methods span.title"); // stepKey: unfocusSelectFreeShippingOption
		$I->waitForPageLoad(30); // stepKey: waitForJavascriptToFinishSelectFreeShippingOption
		$I->click("#order-shipping_method a.action-default"); // stepKey: clickShippingMethodsSelectFreeShippingOption
		$I->waitForPageLoad(30); // stepKey: clickShippingMethodsSelectFreeShippingOptionWaitForPageLoad
		$I->waitForElementVisible("#s_method_freeshipping_freeshipping", 30); // stepKey: waitForShippingOptionsSelectFreeShippingOption
		$I->waitForPageLoad(30); // stepKey: waitForShippingOptionsSelectFreeShippingOptionWaitForPageLoad
		$I->selectOption("#s_method_freeshipping_freeshipping", "freeshipping_freeshipping"); // stepKey: checkFreeShippingSelectFreeShippingOption
		$I->waitForPageLoad(30); // stepKey: checkFreeShippingSelectFreeShippingOptionWaitForPageLoad
		$I->comment("Exiting Action Group [selectFreeShippingOption] OrderSelectFreeShippingActionGroup");
		$I->comment("Entering Action Group [clickSubmitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderClickSubmitOrder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderClickSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadClickSubmitOrder
		$I->comment("Exiting Action Group [clickSubmitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->comment("Create Partial Shipment");
		$I->comment("Entering Action Group [createNewShipment] AdminCreateShipmentFromOrderPage");
		$I->click("#order_ship"); // stepKey: clickShipButtonCreateNewShipment
		$I->waitForPageLoad(30); // stepKey: clickShipButtonCreateNewShipmentWaitForPageLoad
		$I->click("#tracking_numbers_table tfoot [data-ui-id='shipment-tracking-add-button']"); // stepKey: clickAddTrackingNumberCreateNewShipment
		$I->fillField("#tracking_numbers_table tr:nth-of-type(1) .col-title input", "Title"); // stepKey: fillTitleCreateNewShipment
		$I->fillField("#tracking_numbers_table tr:nth-of-type(1) .col-number input", "199"); // stepKey: fillNumberCreateNewShipment
		$I->fillField(".order-shipment-table tbody:nth-of-type(1) .col-qty input.qty-item", "1"); // stepKey: fillQtyCreateNewShipment
		$I->fillField("#shipment_comment_text", "comments for shipment"); // stepKey: fillCommentCreateNewShipment
		$I->click("button.action-default.save.submit-button"); // stepKey: clickSubmitButtonCreateNewShipment
		$I->waitForPageLoad(60); // stepKey: clickSubmitButtonCreateNewShipmentWaitForPageLoad
		$I->see("The shipment has been created."); // stepKey: seeSuccessMessageCreateNewShipment
		$I->comment("Exiting Action Group [createNewShipment] AdminCreateShipmentFromOrderPage");
		$I->comment("Assert There is no \"Ship Button\" in Order Information");
		$I->comment("Entering Action Group [dontSeeShipButton] AssertThereIsNoShipButtonActionGroup");
		$I->dontSee("#order_ship"); // stepKey: dontSeeShipButtonDontSeeShipButton
		$I->waitForPageLoad(30); // stepKey: dontSeeShipButtonDontSeeShipButtonWaitForPageLoad
		$I->comment("Exiting Action Group [dontSeeShipButton] AssertThereIsNoShipButtonActionGroup");
		$I->comment("Assert Created Shipment in Shipments Tab");
		$I->comment("Entering Action Group [assertCreatedShipment] AdminAssertCreatedShipmentsInShipmentsTabActionGroup");
		$I->click("#sales_order_view_tabs_order_shipments"); // stepKey: navigateToShipmentsTabAssertCreatedShipment
		$I->waitForPageLoad(30); // stepKey: waitForTabLoadAssertCreatedShipment
		$grabShipmentIdAssertCreatedShipment = $I->grabTextFrom("//*[@id='sales_order_view_tabs_order_shipments_content']//tbody/tr/td[2]/div"); // stepKey: grabShipmentIdAssertCreatedShipment
		$I->assertNotEmpty($grabShipmentIdAssertCreatedShipment); // stepKey: assertShipmentIdIsNotEmptyAssertCreatedShipment
		$I->comment("Exiting Action Group [assertCreatedShipment] AdminAssertCreatedShipmentsInShipmentsTabActionGroup");
		$grabShipmentId = $I->grabTextFrom("//*[@id='sales_order_view_tabs_order_shipments_content']//tbody/tr/td[2]/div"); // stepKey: grabShipmentId
		$I->comment("Assert Shipment items");
		$I->comment("Entering Action Group [assertShipmentItems] AdminAssertShipmentItemsActionGroup");
		$I->click("//*[@id='sales_order_view_tabs_order_shipments_content']//tbody/tr/td[2]/div"); // stepKey: clickViewAssertShipmentItems
		$I->scrollTo(".order-shipment-table tbody:nth-of-type(1) .col-product .product-title"); // stepKey: scrollToShippedItemsAssertShipmentItems
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".order-shipment-table tbody:nth-of-type(1) .col-product .product-title"); // stepKey: seeProductNameAssertShipmentItems
		$I->see("1", "td.col-qty"); // stepKey: seeQtyAssertShipmentItems
		$I->comment("Exiting Action Group [assertShipmentItems] AdminAssertShipmentItemsActionGroup");
		$I->comment("Assert Created Shipment in Shipments Grid");
		$I->comment("Entering Action Group [assertShipmentInGrid] AdminAssertShipmentInShipmentsGrid");
		$I->comment("Assert Shipment in Shipments Grid");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/shipment/"); // stepKey: onShipmentsGridPageAssertShipmentInGrid
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageAssertShipmentInGrid
		$I->conditionalClick("button.action-tertiary.action-clear", "button.action-tertiary.action-clear", true); // stepKey: clearFilterAssertShipmentInGrid
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFilterLoadAssertShipmentInGrid
		$I->click(".data-grid-filters-action-wrap > button"); // stepKey: openFilterSearchAssertShipmentInGrid
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFilterFieldsAssertShipmentInGrid
		$I->fillField("input[name='increment_id']", $grabShipmentId); // stepKey: fillSearchByShipmentIdAssertShipmentInGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchButtonAssertShipmentInGrid
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSearchResultAssertShipmentInGrid
		$I->see($grabShipmentId, "div.data-grid-cell-content"); // stepKey: seeShipmentIdAssertShipmentInGrid
		$I->comment("Exiting Action Group [assertShipmentInGrid] AdminAssertShipmentInShipmentsGrid");
	}
}
