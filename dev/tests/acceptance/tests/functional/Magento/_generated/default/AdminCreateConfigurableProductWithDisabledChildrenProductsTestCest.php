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
 * @Title("MC-13711: Create configurable product with disabled children products")
 * @Description("Admin should be able to create configurable product with disabled children products, assigned to category<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/AdminCreateConfigurableProductWithDisabledChildrenProductsTest.xml<br>")
 * @TestCaseId("MC-13711")
 * @group mtf_migrated
 */
class AdminCreateConfigurableProductWithDisabledChildrenProductsTestCest
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
		$I->comment("Create attribute with one options");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptionsNotVisible", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption
		$I->comment("Create the child that will be a part of the configurable product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProductOffline", ["createConfigProductAttribute", "getConfigAttributeOption"], []); // stepKey: createSimpleProduct
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
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
		$I->comment("Don't display out of stock product");
		$I->comment("Entering Action Group [revertDisplayOutOfStockProduct] NoDisplayOutOfStockProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/cataloginventory/"); // stepKey: navigateToInventoryConfigurationPageRevertDisplayOutOfStockProduct
		$I->waitForPageLoad(30); // stepKey: waitForConfigPageToLoadRevertDisplayOutOfStockProduct
		$I->conditionalClick("#cataloginventory_options-head", "#cataloginventory_options-head:not(.open)", true); // stepKey: expandProductStockOptionsRevertDisplayOutOfStockProduct
		$I->uncheckOption("#cataloginventory_options_show_out_of_stock_inherit"); // stepKey: uncheckUseSystemValueRevertDisplayOutOfStockProduct
		$I->waitForElementVisible("#cataloginventory_options_show_out_of_stock", 30); // stepKey: waitForSwitcherDropdownRevertDisplayOutOfStockProduct
		$I->selectOption("#cataloginventory_options_show_out_of_stock", "No"); // stepKey: switchToNoRevertDisplayOutOfStockProduct
		$I->click("#save"); // stepKey: clickSaveConfigRevertDisplayOutOfStockProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigRevertDisplayOutOfStockProductWaitForPageLoad
		$I->comment("Exiting Action Group [revertDisplayOutOfStockProduct] NoDisplayOutOfStockProductActionGroup");
		$I->comment("Delete configurable product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("api-configurable-product" . msq("ApiConfigurableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Delete created data");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteAttribute
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Log out");
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
	 * @Stories({"Create configurable product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateConfigurableProductWithDisabledChildrenProductsTest(AcceptanceTester $I)
	{
		$I->comment("Create configurable product");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [createConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleCreateConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-configurable']", 30); // stepKey: waitForAddProductDropdownCreateConfigurableProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickAddProductTypeCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadCreateConfigurableProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/configurable/"); // stepKey: seeNewProductUrlCreateConfigurableProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleCreateConfigurableProduct
		$I->comment("Exiting Action Group [createConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->comment("Fill configurable product values");
		$I->comment("Entering Action Group [fillConfigurableProductValues] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=name] input", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: fillProductNameFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=sku] input", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillConfigurableProductValues
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillConfigurableProductValues
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillConfigurableProductValuesWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillConfigurableProductValues
		$I->fillField(".admin__field[data-index=weight] input", "2"); // stepKey: fillProductWeightFillConfigurableProductValues
		$I->comment("Exiting Action Group [fillConfigurableProductValues] FillMainProductFormActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: fillCategory
		$I->waitForPageLoad(30); // stepKey: fillCategoryWaitForPageLoad
		$I->comment("Entering Action Group [generateConfigurationsByAttributeCode] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurationsGenerateConfigurationsByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsGenerateConfigurationsByAttributeCodeWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersGenerateConfigurationsByAttributeCode
		$I->fillField(".admin__control-text[name='attribute_code']", $I->retrieveEntityField('createConfigProductAttribute', 'attribute_code', 'test')); // stepKey: fillFilterAttributeCodeFieldGenerateConfigurationsByAttributeCode
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonGenerateConfigurationsByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonGenerateConfigurationsByAttributeCodeWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckboxGenerateConfigurationsByAttributeCode
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1GenerateConfigurationsByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1GenerateConfigurationsByAttributeCodeWaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAllGenerateConfigurationsByAttributeCode
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2GenerateConfigurationsByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2GenerateConfigurationsByAttributeCodeWaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSkuGenerateConfigurationsByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuGenerateConfigurationsByAttributeCodeWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "99"); // stepKey: enterAttributeQuantityGenerateConfigurationsByAttributeCode
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3GenerateConfigurationsByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3GenerateConfigurationsByAttributeCodeWaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4GenerateConfigurationsByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4GenerateConfigurationsByAttributeCodeWaitForPageLoad
		$I->comment("Exiting Action Group [generateConfigurationsByAttributeCode] GenerateConfigurationsByAttributeCodeActionGroup");
		$I->comment("Create product configurations and add attribute and select all options");
		$I->comment("Add configurable product to category");
		$I->comment("Add child product to configurations grid");
		$I->comment("Entering Action Group [addSimpleProduct] AddProductToConfigurationsGridActionGroup");
		$I->click("//*[.='Attributes']/ancestor::tr/td[@data-index='attributes']//span[contains(text(), '" . $I->retrieveEntityField('createConfigProductAttributeOption', 'option[store_labels][1][label]', 'test') . "')]/ancestor::tr//button[@class='action-select']"); // stepKey: clickToExpandFirstActionsAddSimpleProduct
		$I->click("//*[.='Attributes']/ancestor::tr/td[@data-index='attributes']//span[contains(text(), '" . $I->retrieveEntityField('createConfigProductAttributeOption', 'option[store_labels][1][label]', 'test') . "')]/ancestor::tr//a[text()='Choose a different Product']"); // stepKey: clickChooseFirstDifferentProductAddSimpleProduct
		$I->switchToIFrame(); // stepKey: switchOutOfIFrameAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAddSimpleProduct
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFiltersAddSimpleProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createSimpleProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterAddSimpleProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddSimpleProductWaitForPageLoad
		$I->click("//div[text()='" . $I->retrieveEntityField('createSimpleProduct', 'sku', 'test') . "']/ancestor::tr"); // stepKey: clickOnFirstRowAddSimpleProduct
		$I->waitForPageLoad(30); // stepKey: clickOnFirstRowAddSimpleProductWaitForPageLoad
		$I->comment("Exiting Action Group [addSimpleProduct] AddProductToConfigurationsGridActionGroup");
		$I->comment("Save configurable product");
		$I->comment("Entering Action Group [saveConfigurableProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveConfigurableProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveConfigurableProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveConfigurableProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveConfigurableProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveConfigurableProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveConfigurableProduct
		$I->comment("Exiting Action Group [saveConfigurableProduct] SaveProductFormActionGroup");
		$I->comment("Find configurable product in grid");
		$I->comment("Entering Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage
		$I->comment("Exiting Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [findCreatedConfigurableProduct] FilterProductGridBySkuActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFindCreatedConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFindCreatedConfigurableProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFindCreatedConfigurableProduct
		$I->fillField("input.admin__control-text[name='sku']", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: fillProductSkuFilterFindCreatedConfigurableProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFindCreatedConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFindCreatedConfigurableProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFindCreatedConfigurableProduct
		$I->comment("Exiting Action Group [findCreatedConfigurableProduct] FilterProductGridBySkuActionGroup");
		$I->comment("Assert configurable product on admin product page");
		$I->comment("Entering Action Group [clickOnProductPage] AdminProductGridSectionClickFirstRowActionGroup");
		$I->click("tr.data-row:nth-of-type(1)"); // stepKey: clickOnProductPageClickOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadClickOnProductPage
		$I->comment("Exiting Action Group [clickOnProductPage] AdminProductGridSectionClickFirstRowActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductOnAdminProductPage] AssertConfigurableProductOnAdminProductPageActionGroup");
		$I->seeInField(".admin__field[data-index=name] input", "API Configurable Product" . msq("ApiConfigurableProduct")); // stepKey: seeNameRequiredAssertConfigurableProductOnAdminProductPage
		$I->seeInField(".admin__field[data-index=sku] input", "api-configurable-product" . msq("ApiConfigurableProduct")); // stepKey: seeSkuRequiredAssertConfigurableProductOnAdminProductPage
		$I->dontSeeInField(".admin__field[data-index=price] input", "123.00"); // stepKey: dontSeePriceRequiredAssertConfigurableProductOnAdminProductPage
		$I->comment("Exiting Action Group [assertConfigurableProductOnAdminProductPage] AssertConfigurableProductOnAdminProductPageActionGroup");
		$I->comment("Assert configurable attributes block is present on product page");
		$I->scrollTo(".admin__collapsible-block-wrapper[data-index='configurable']"); // stepKey: scrollToSearchEngineTab
		$I->seeElement("div.admin__field.admin__field-wide"); // stepKey: seeCreatedConfigurations
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".admin__control-fields[data-index='name_container']"); // stepKey: seeProductNameInConfigurations
		$I->comment("Display out of stock product");
		$I->comment("Entering Action Group [displayOutOfStockProduct] DisplayOutOfStockProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/cataloginventory/"); // stepKey: navigateToInventoryConfigurationPageDisplayOutOfStockProduct
		$I->waitForPageLoad(30); // stepKey: waitForConfigPageToLoadDisplayOutOfStockProduct
		$I->conditionalClick("#cataloginventory_options-head", "#cataloginventory_options-head:not(.open)", true); // stepKey: expandProductStockOptionsDisplayOutOfStockProduct
		$I->waitForElementVisible("#cataloginventory_options_show_out_of_stock_inherit", 30); // stepKey: waitForDisplayOutOfStockOptionDisplayOutOfStockProduct
		$I->uncheckOption("#cataloginventory_options_show_out_of_stock_inherit"); // stepKey: uncheckUseSystemValueDisplayOutOfStockProduct
		$I->waitForElementVisible("#cataloginventory_options_show_out_of_stock", 30); // stepKey: waitForSwitcherDropdownDisplayOutOfStockProduct
		$I->selectOption("#cataloginventory_options_show_out_of_stock", "Yes"); // stepKey: switchToYesDisplayOutOfStockProduct
		$I->click("#save"); // stepKey: clickSaveConfigDisplayOutOfStockProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigDisplayOutOfStockProductWaitForPageLoad
		$I->comment("Exiting Action Group [displayOutOfStockProduct] DisplayOutOfStockProductActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Assert configurable product is not present in category");
		$I->comment("Entering Action Group [amOnCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageAmOnCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadAmOnCategoryPage
		$I->comment("Exiting Action Group [amOnCategoryPage] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [seeEmptyProductMessage] AssertStorefrontNoProductsFoundActionGroup");
		$I->see("We can't find products matching the selection."); // stepKey: seeEmptyNoticeSeeEmptyProductMessage
		$I->comment("Exiting Action Group [seeEmptyProductMessage] AssertStorefrontNoProductsFoundActionGroup");
		$I->comment("Assert configurable product is out of stock");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [checkForOutOfStock] StorefrontCheckProductStockStatus");
		$I->amOnPage("/api-configurable-product" . msq("ApiConfigurableProduct") . ".html"); // stepKey: navigateToProductPageCheckForOutOfStock
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadCheckForOutOfStock
		$I->see("API Configurable Product" . msq("ApiConfigurableProduct"), ".base"); // stepKey: seeProductNameCheckForOutOfStock
		$I->see("Out of stock"); // stepKey: assertProductStockStatusCheckForOutOfStock
		$I->comment("Exiting Action Group [checkForOutOfStock] StorefrontCheckProductStockStatus");
	}
}
