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
 * @Title("MC-17373: Disabled variation of configurable product can't be added to shopping cart via admin")
 * @Description("Disabled variation of configurable product can't be added to shopping cart via admin<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/NoOptionAvailableToConfigureDisabledProductTest.xml<br>")
 * @TestCaseId("MC-17373")
 * @group ConfigurableProduct
 */
class NoOptionAvailableToConfigureDisabledProductTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create category");
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Create the configurable product based on the data in the data folder");
		$I->comment("Create the configurable product based on the data in the data folder");
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Create the configurable product with two options based on the default attribute set");
		$I->comment("Create the configurable product with two options based on the default attribute set");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigProductAttributeOption3", "hook", "productAttributeOption3", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption3
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->getEntity("getConfigAttributeOption3", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 3); // stepKey: getConfigAttributeOption3
		$I->comment("Create the 3 children that will be a part of the configurable product");
		$I->comment("Create the 3 children that will be a part of the configurable product");
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleProductWithPrice50", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleProductWithPrice60", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->createEntity("createConfigChildProduct3", "hook", "ApiSimpleProductWithPrice70", ["createConfigProductAttribute", "getConfigAttributeOption3"], []); // stepKey: createConfigChildProduct3
		$I->comment("Assign 3 products to the configurable product");
		$I->comment("Assign 3 products to the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2", "getConfigAttributeOption3"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->createEntity("createConfigProductAddChild3", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct3"], []); // stepKey: createConfigProductAddChild3
		$I->comment("Create Customer");
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_CA", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->comment("Delete created data");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory2
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigChildProduct3", "hook"); // stepKey: deleteConfigChildProduct3
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCreatedCustomer
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"Admin order configurable product"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function NoOptionAvailableToConfigureDisabledProductTest(AcceptanceTester $I)
	{
		$I->comment("Disable child product");
		$I->comment("Disable child product");
		$I->comment("Entering Action Group [goToEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct1', 'id', 'test')); // stepKey: goToProductGoToEditPage
		$I->comment("Exiting Action Group [goToEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForChildProductPageLoad
		$I->click("input[name='product[status]']+label"); // stepKey: disableProduct
		$I->comment("Entering Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductForm
		$I->comment("Exiting Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->comment("Set the second product out of stock");
		$I->comment("Set the second product out of stock");
		$I->comment("Entering Action Group [goToSecondProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct2', 'id', 'test')); // stepKey: goToProductGoToSecondProductEditPage
		$I->comment("Exiting Action Group [goToSecondProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForSecondChildProductPageLoad
		$I->comment("Entering Action Group [outOfStockStatus] AdminSetStockStatusActionGroup");
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "Out of Stock"); // stepKey: setStockStatusOutOfStockStatus
		$I->waitForPageLoad(30); // stepKey: setStockStatusOutOfStockStatusWaitForPageLoad
		$I->comment("Exiting Action Group [outOfStockStatus] AdminSetStockStatusActionGroup");
		$I->comment("Entering Action Group [saveSecondProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveSecondProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveSecondProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveSecondProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveSecondProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveSecondProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveSecondProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveSecondProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveSecondProductForm
		$I->comment("Exiting Action Group [saveSecondProductForm] SaveProductFormActionGroup");
		$I->comment("Go to created customer page");
		$I->comment("Go to created customer page");
		$I->comment("Entering Action Group [createNewOrder] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadCreateNewOrder
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleCreateNewOrder
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadCreateNewOrder
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersCreateNewOrderWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailCreateNewOrder
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadCreateNewOrder
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadCreateNewOrder
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsCreateNewOrder
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsCreateNewOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectCreateNewOrder
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleCreateNewOrder
		$I->comment("Exiting Action Group [createNewOrder] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickToAddProduct
		$I->waitForPageLoad(30); // stepKey: clickToAddProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductsOpened
		$I->comment("Find created configurable product and click on \"Configure\" link");
		$I->comment("Find created configurable product and click on Configure link");
		$I->click("//a[@product_id='" . $I->retrieveEntityField('createConfigProduct', 'id', 'test') . "']"); // stepKey: clickOnConfigure
		$I->comment("Click on attribute drop-down and check no option 1 is available");
		$I->comment("Click on attribute drop-down and check no option 1 is available");
		$I->waitForPageLoad(30); // stepKey: waitForConfigure
		$I->waitForElementVisible("//form[@id='product_composite_configure_form']//select", 30); // stepKey: waitForShippingSectionLoaded
		$I->click("//form[@id='product_composite_configure_form']//select"); // stepKey: clickToSelectOption
		$I->dontSee($I->retrieveEntityField('createConfigProductAttributeOption1', 'option[store_labels][1][label]', 'test')); // stepKey: dontSeeOption1
		$I->comment("Go to created customer page again");
		$I->comment("Go to created customer page again");
		$I->comment("Entering Action Group [createNewOrderAgain] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageCreateNewOrderAgain
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadCreateNewOrderAgain
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleCreateNewOrderAgain
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderCreateNewOrderAgain
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderCreateNewOrderAgainWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadCreateNewOrderAgain
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersCreateNewOrderAgain
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersCreateNewOrderAgainWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailCreateNewOrderAgain
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterCreateNewOrderAgain
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadCreateNewOrderAgain
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerCreateNewOrderAgain
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadCreateNewOrderAgain
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsCreateNewOrderAgain
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsCreateNewOrderAgainWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectCreateNewOrderAgain
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleCreateNewOrderAgain
		$I->comment("Exiting Action Group [createNewOrderAgain] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickToAddProductAgain
		$I->waitForPageLoad(30); // stepKey: clickToAddProductAgainWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductsOpenedAgain
		$I->fillField("#sales_order_create_search_grid_filter_entity_id", $I->retrieveEntityField('createConfigChildProduct2', 'id', 'test')); // stepKey: idFilter
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearch
		$I->waitForPageLoad(30); // stepKey: clickSearchWaitForPageLoad
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectConfigurableProduct
		$I->comment("Add product to order");
		$I->comment("Add product to order");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickToAddProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickToAddProductToOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForNewOrderPageLoad
		$I->see("There are no source items with the in stock status"); // stepKey: seeTheErrorMessageDisplayed
		$I->comment("Entering Action Group [createNewOrderThirdTime] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderIndexPageCreateNewOrderThirdTime
		$I->waitForPageLoad(30); // stepKey: waitForIndexPageLoadCreateNewOrderThirdTime
		$I->see("Orders", ".page-header h1.page-title"); // stepKey: seeIndexPageTitleCreateNewOrderThirdTime
		$I->click(".page-actions-buttons button#add"); // stepKey: clickCreateNewOrderCreateNewOrderThirdTime
		$I->waitForPageLoad(30); // stepKey: clickCreateNewOrderCreateNewOrderThirdTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGridLoadCreateNewOrderThirdTime
		$I->comment("Clear grid filters");
		$I->conditionalClick("#sales_order_create_customer_grid [data-action='grid-filter-reset']", "#sales_order_create_customer_grid [data-action='grid-filter-reset']", true); // stepKey: clearExistingCustomerFiltersCreateNewOrderThirdTime
		$I->waitForPageLoad(30); // stepKey: clearExistingCustomerFiltersCreateNewOrderThirdTimeWaitForPageLoad
		$I->fillField("#sales_order_create_customer_grid_filter_email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: filterEmailCreateNewOrderThirdTime
		$I->click(".action-secondary[title='Search']"); // stepKey: applyFilterCreateNewOrderThirdTime
		$I->waitForPageLoad(30); // stepKey: waitForFilteredCustomerGridLoadCreateNewOrderThirdTime
		$I->click("tr:nth-of-type(1)[data-role='row']"); // stepKey: clickOnCustomerCreateNewOrderThirdTime
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadCreateNewOrderThirdTime
		$I->comment("Select store view if appears");
		$I->conditionalClick("//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", "//div[contains(@class, 'tree-store-scope')]//label[contains(text(), 'Default Store View')]/preceding-sibling::input", true); // stepKey: selectStoreViewIfAppearsCreateNewOrderThirdTime
		$I->waitForPageLoad(30); // stepKey: selectStoreViewIfAppearsCreateNewOrderThirdTimeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCreateOrderPageLoadAfterStoreSelectCreateNewOrderThirdTime
		$I->see("Create New Order", ".page-header h1.page-title"); // stepKey: seeNewOrderPageTitleCreateNewOrderThirdTime
		$I->comment("Exiting Action Group [createNewOrderThirdTime] NavigateToNewOrderPageExistingCustomerActionGroup");
		$I->comment("Entering Action Group [addThirdChildProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->click("//section[@id='order-items']/div/div/button/span[text() = 'Add Products']"); // stepKey: clickAddProductsAddThirdChildProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddProductsAddThirdChildProductToOrderWaitForPageLoad
		$I->fillField("#sales_order_create_search_grid_filter_sku", $I->retrieveEntityField('createConfigChildProduct3', 'sku', 'test')); // stepKey: fillSkuFilterAddThirdChildProductToOrder
		$I->click("#sales_order_create_search_grid [data-action='grid-filter-apply']"); // stepKey: clickSearchAddThirdChildProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickSearchAddThirdChildProductToOrderWaitForPageLoad
		$I->scrollTo("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]", 0, -100); // stepKey: scrollToCheckColumnAddThirdChildProductToOrder
		$I->checkOption("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-select [type=checkbox]"); // stepKey: selectProductAddThirdChildProductToOrder
		$I->fillField("#sales_order_create_search_grid_table > tbody tr:nth-of-type(1) td.col-qty [name='qty']", "1"); // stepKey: fillProductQtyAddThirdChildProductToOrder
		$I->scrollTo("#order-search .admin__page-section-title .actions button.action-add", 0, -100); // stepKey: scrollToAddSelectedButtonAddThirdChildProductToOrder
		$I->waitForPageLoad(30); // stepKey: scrollToAddSelectedButtonAddThirdChildProductToOrderWaitForPageLoad
		$I->click("#order-search .admin__page-section-title .actions button.action-add"); // stepKey: clickAddSelectedProductsAddThirdChildProductToOrder
		$I->waitForPageLoad(30); // stepKey: clickAddSelectedProductsAddThirdChildProductToOrderWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForOptionsToLoadAddThirdChildProductToOrder
		$I->comment("Exiting Action Group [addThirdChildProductToOrder] AddSimpleProductToOrderActionGroup");
		$I->comment("Entering Action Group [assertNoticeAbsent] AssertAdminItemOrderedErrorNotVisibleActionGroup");
		$I->dontSee("The requested qty is not available", "//section[@id = 'order-items']//span[text()='" . $I->retrieveEntityField('createConfigChildProduct3', 'name', 'test') . "']/ancestor::tr/..//div[contains(@class, 'message-notice')]"); // stepKey: assertItemErrorNotVisibleAssertNoticeAbsent
		$I->dontSee("The requested qty is not available", "#order-message div.message-notice"); // stepKey: assertOrderErrorNotVisibleAssertNoticeAbsent
		$I->comment("Exiting Action Group [assertNoticeAbsent] AssertAdminItemOrderedErrorNotVisibleActionGroup");
		$I->comment("Entering Action Group [assertErrorAbsent] AssertAdminItemOrderedErrorNotVisibleActionGroup");
		$I->dontSee("The requested qty is not available", "//section[@id = 'order-items']//span[text()='" . $I->retrieveEntityField('createConfigChildProduct3', 'name', 'test') . "']/ancestor::tr/..//div[contains(@class, 'message-error')]"); // stepKey: assertItemErrorNotVisibleAssertErrorAbsent
		$I->dontSee("The requested qty is not available", "#order-message div.message-error"); // stepKey: assertOrderErrorNotVisibleAssertErrorAbsent
		$I->comment("Exiting Action Group [assertErrorAbsent] AssertAdminItemOrderedErrorNotVisibleActionGroup");
		$I->comment("Select shipping method");
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
		$I->comment("Entering Action Group [clickSubmitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->click("#submit_order_top_button"); // stepKey: clickSubmitOrderClickSubmitOrder
		$I->waitForPageLoad(30); // stepKey: clickSubmitOrderClickSubmitOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoadClickSubmitOrder
		$I->comment("Exiting Action Group [clickSubmitOrder] AdminOrderClickSubmitOrderActionGroup");
		$I->comment("Entering Action Group [checkOrderSuccessfullyCreated] VerifyCreatedOrderInformationActionGroup");
		$I->see("You created the order.", "div.message-success"); // stepKey: seeSuccessMessageCheckOrderSuccessfullyCreated
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderPendingStatusCheckOrderSuccessfullyCreated
		$getOrderIdCheckOrderSuccessfullyCreated = $I->grabTextFrom("|Order # (\d+)|"); // stepKey: getOrderIdCheckOrderSuccessfullyCreated
		$I->assertNotEmpty($getOrderIdCheckOrderSuccessfullyCreated); // stepKey: assertOrderIdIsNotEmptyCheckOrderSuccessfullyCreated
		$I->comment("Exiting Action Group [checkOrderSuccessfullyCreated] VerifyCreatedOrderInformationActionGroup");
	}
}
