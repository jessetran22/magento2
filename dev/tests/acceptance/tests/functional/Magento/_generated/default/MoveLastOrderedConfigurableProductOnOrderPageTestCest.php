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
 * @Title("MC-16155: Move last ordered configurable product on order page test")
 * @Description("Move last ordered configurable product on order page<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/MoveLastOrderedConfigurableProductOnOrderPageTest.xml<br>")
 * @TestCaseId("MC-16155")
 * @group sales
 * @group mtf_migrated
 */
class MoveLastOrderedConfigurableProductOnOrderPageTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_CA_Customer", [], []); // stepKey: createCustomer
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create configurable product");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption
		$I->createEntity("createConfigChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption", "createCategory"], []); // stepKey: createConfigChildProduct
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct"], []); // stepKey: createConfigProductAddChild
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createConfigChildProduct", "hook"); // stepKey: deleteConfigChildProduct
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Add Products to Order from Last Ordered Products Section"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function MoveLastOrderedConfigurableProductOnOrderPageTest(AcceptanceTester $I)
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
		$I->selectOption("//div[contains(@class,'product-options')]//select[//label[text() = '" . $I->retrieveEntityField('createConfigProductAttribute', 'default_frontend_label', 'test') . "']]", $I->retrieveEntityField('getConfigAttributeOption', 'label', 'test')); // stepKey: selectionConfigurableOptionAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: selectionConfigurableOptionAddConfigurableProductToOrderWaitForPageLoad
		$I->click(".modal-header .page-actions button[data-role='action']"); // stepKey: clickOkConfigurablePopoverAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickOkConfigurablePopoverAddConfigurableProductToOrderWaitForPageLoad
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddConfigurableProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddConfigurableProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddConfigurableProductToOrderWaitForPageLoad
		$I->comment("Exiting Action Group [addConfigurableProductToOrder] AddConfigurableProductToOrderFromAdminActionGroup");
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
		$I->comment("Search and open customer");
		$I->comment("Entering Action Group [filterCreatedCustomer] AdminFilterCustomerByEmail");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: openCustomerIndexPageFilterCreatedCustomer
		$I->waitForPageLoad(30); // stepKey: waitToCustomerIndexPageToLoadFilterCreatedCustomer
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerIndexPageFilterCreatedCustomer
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerIndexPageFilterCreatedCustomerWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterCreatedCustomer
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterCreatedCustomerWaitForPageLoad
		$I->fillField("input[name=email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailFilterCreatedCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterFilterCreatedCustomer
		$I->waitForPageLoad(30); // stepKey: applyFilterFilterCreatedCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadFilterCreatedCustomer
		$I->comment("Exiting Action Group [filterCreatedCustomer] AdminFilterCustomerByEmail");
		$I->comment("Entering Action Group [clickEditButton] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->click("tr[data-repeat-index='0'] .action-menu-item"); // stepKey: clickOnEditLinkClickEditButton
		$I->waitForPageLoad(30); // stepKey: clickOnEditLinkClickEditButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadingClickEditButton
		$I->comment("Exiting Action Group [clickEditButton] AdminClickFirstRowEditLinkOnCustomerGridActionGroup");
		$I->comment("Click create order");
		$I->click("#order"); // stepKey: clickCreateOrder
		$I->waitForPageLoad(30); // stepKey: clickCreateOrderWaitForPageLoad
		$I->comment("Select product in Last Ordered Items section");
		$I->click("//div[@id='sidebar_data_reorder']//tr[td[.='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "']]//input[contains(@name,'add')]"); // stepKey: addProductToOrder
		$I->waitForPageLoad(30); // stepKey: addProductToOrderWaitForPageLoad
		$I->comment("Click Update Changes");
		$I->comment("Entering Action Group [clickUpdateChangesBtn] AdminClickUpdateChangesOnCreateOrderPageActionGroup");
		$I->click(".order-sidebar .actions .action-default.scalable"); // stepKey: clickUpdateChangesBtnClickUpdateChangesBtn
		$I->waitForPageLoad(30); // stepKey: clickUpdateChangesBtnClickUpdateChangesBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderUpdatingClickUpdateChangesBtn
		$I->comment("Exiting Action Group [clickUpdateChangesBtn] AdminClickUpdateChangesOnCreateOrderPageActionGroup");
		$I->comment("Assert product in items ordered grid");
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), "//div[contains(@id, 'order-items_grid')]//tbody[1]//td[count(//table[contains(@class, 'order-tables')]//th[contains(., 'Product')]/preceding-sibling::th) +1 ]"); // stepKey: seeProductName
		$I->waitForPageLoad(30); // stepKey: seeProductNameWaitForPageLoad
		$I->see("$123.00", "//div[contains(@id, 'order-items_grid')]//tbody[1]//td[count(//table[contains(@class, 'order-tables')]//th[contains(., 'Price')]/preceding-sibling::th) +1 ]"); // stepKey: seeProductPrice
		$I->waitForPageLoad(30); // stepKey: seeProductPriceWaitForPageLoad
	}
}
