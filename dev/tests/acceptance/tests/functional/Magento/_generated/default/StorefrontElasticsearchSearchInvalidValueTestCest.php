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
 * @Title("MC-17906: Elasticsearch: try to search by invalid value of 'Searchable' attribute")
 * @Description("Elasticsearch: try to search by invalid value of 'Searchable' attribute<h3>Test files</h3>app/code/Magento/Elasticsearch6/Test/Mftf/Test/StorefrontElasticsearchSearchInvalidValueTest.xml<br>")
 * @TestCaseId("MC-17906")
 * @group elasticsearch
 */
class StorefrontElasticsearchSearchInvalidValueTestCest
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
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->comment("Set Minimal Query Length");
		$setMinQueryLength = $I->magentoCLI("config:set catalog/search/min_query_length 2", 60); // stepKey: setMinQueryLength
		$I->comment($setMinQueryLength);
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Set configs to default");
		$setMinQueryLengthPreviousState = $I->magentoCLI("config:set catalog/search/min_query_length 3", 60); // stepKey: setMinQueryLengthPreviousState
		$I->comment($setMinQueryLengthPreviousState);
		$I->comment("Delete created data");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [openProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridOpenProductAttributeFromSearchResultInGrid
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridSectionLoadOpenProductAttributeFromSearchResultInGrid
		$I->fillField("#attributeGrid_filter_attribute_code", "attribute" . msq("textProductAttribute")); // stepKey: setAttributeCodeOpenProductAttributeFromSearchResultInGrid
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeFromTheGridOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: searchForAttributeFromTheGridOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOnGridToDisappearOpenProductAttributeFromSearchResultInGrid
		$I->waitForElementVisible("//td[contains(text(),'attribute" . msq("textProductAttribute") . "')]", 30); // stepKey: waitForAdminProductAttributeGridLoadOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: waitForAdminProductAttributeGridLoadOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->see("attribute" . msq("textProductAttribute"), "//div[@id='attributeGrid']//td[contains(@class,'col-attr-code col-attribute_code')]"); // stepKey: seeAttributeCodeInGridOpenProductAttributeFromSearchResultInGrid
		$I->click("//td[contains(text(),'attribute" . msq("textProductAttribute") . "')]"); // stepKey: clickAttributeToViewOpenProductAttributeFromSearchResultInGrid
		$I->waitForPageLoad(30); // stepKey: clickAttributeToViewOpenProductAttributeFromSearchResultInGridWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadOpenProductAttributeFromSearchResultInGrid
		$I->comment("Exiting Action Group [openProductAttributeFromSearchResultInGrid] OpenProductAttributeFromSearchResultInGridActionGroup");
		$I->comment("Entering Action Group [deleteProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForViewAdminProductAttributeLoadDeleteProductAttributeByAttributeCode
		$I->click("#delete"); // stepKey: deleteAttributeDeleteProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: deleteAttributeDeleteProductAttributeByAttributeCodeWaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: clickOnConfirmOkDeleteProductAttributeByAttributeCode
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmOkDeleteProductAttributeByAttributeCodeWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForViewProductAttributePageLoadDeleteProductAttributeByAttributeCode
		$I->comment("Exiting Action Group [deleteProductAttributeByAttributeCode] DeleteProductAttributeByAttributeCodeActionGroup");
		$I->comment("Entering Action Group [deleteProductAttributeSuccess] AssertProductAttributeRemovedSuccessfullyActionGroup");
		$I->seeElement(".message.message-success.success"); // stepKey: waitForSuccessMessageDeleteProductAttributeSuccess
		$I->comment("Exiting Action Group [deleteProductAttributeSuccess] AssertProductAttributeRemovedSuccessfullyActionGroup");
		$I->comment("Entering Action Group [navigateToProductAttributeGrid] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageNavigateToProductAttributeGrid
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadNavigateToProductAttributeGrid
		$I->comment("Exiting Action Group [navigateToProductAttributeGrid] AdminOpenProductAttributePageActionGroup");
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGrid
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridWaitForPageLoad
		$I->comment("Entering Action Group [goToProductCatalog] AdminProductCatalogPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: openProductCatalogPageGoToProductCatalog
		$I->waitForPageLoad(30); // stepKey: waitForProductCatalogPageLoadGoToProductCatalog
		$I->comment("Exiting Action Group [goToProductCatalog] AdminProductCatalogPageOpenActionGroup");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteProduct
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteProductWaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteProduct
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductsIfTheyExistActionGroup");
		$I->comment("Entering Action Group [resetFiltersIfExist] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetFiltersIfExist
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetFiltersIfExistWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetFiltersIfExist
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetFiltersIfExist
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetFiltersIfExistWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetFiltersIfExist
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetFiltersIfExist
		$I->comment("Exiting Action Group [resetFiltersIfExist] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
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
	 * @Features({"Elasticsearch6"})
	 * @Stories({"Search Product on Storefront"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontElasticsearchSearchInvalidValueTest(AcceptanceTester $I)
	{
		$I->comment("Create new searchable product attribute");
		$I->comment("Entering Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: goToAttributePageGoToProductAttributes
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadGoToProductAttributes
		$I->comment("Exiting Action Group [goToProductAttributes] AdminOpenProductAttributePageActionGroup");
		$I->comment("Entering Action Group [createAttribute] AdminCreateSearchableProductAttributeActionGroup");
		$I->click("#add"); // stepKey: createNewAttributeCreateAttribute
		$I->fillField("#attribute_label", "attribute" . msq("textProductAttribute")); // stepKey: fillDefaultLabelCreateAttribute
		$I->selectOption("#frontend_input", "text"); // stepKey: checkInputTypeCreateAttribute
		$I->selectOption("#is_required", "No"); // stepKey: checkRequiredCreateAttribute
		$I->click("#product_attribute_tabs_front"); // stepKey: goToStorefrontPropertiesTabCreateAttribute
		$I->waitForElementVisible("//span[text()='Storefront Properties']", 30); // stepKey: waitTabLoadCreateAttribute
		$I->selectOption("#is_searchable", "Yes"); // stepKey: setSearchableCreateAttribute
		$I->click("#save"); // stepKey: saveAttributeCreateAttribute
		$I->waitForPageLoad(30); // stepKey: saveAttributeCreateAttributeWaitForPageLoad
		$I->comment("Exiting Action Group [createAttribute] AdminCreateSearchableProductAttributeActionGroup");
		$I->comment("Assign attribute to the Default set");
		$I->comment("Entering Action Group [openAttributeSetPage] AdminOpenAttributeSetGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_set/"); // stepKey: goToAttributeSetPageOpenAttributeSetPage
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetPageLoadOpenAttributeSetPage
		$I->comment("Exiting Action Group [openAttributeSetPage] AdminOpenAttributeSetGridPageActionGroup");
		$I->comment("Entering Action Group [openDefaultAttributeSet] AdminOpenAttributeSetByNameActionGroup");
		$I->click("//td[contains(text(), 'Default')]"); // stepKey: chooseAttributeSetOpenDefaultAttributeSet
		$I->waitForPageLoad(30); // stepKey: waitForAttributeSetPageLoadOpenDefaultAttributeSet
		$I->comment("Exiting Action Group [openDefaultAttributeSet] AdminOpenAttributeSetByNameActionGroup");
		$I->comment("Entering Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->conditionalClick("//*[@id='tree-div1']//span[text()='Product Details']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*[contains(@class, 'collapsed')]", true); // stepKey: extendGroupAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignAttributeToGroup
		$I->dragAndDrop("//*[@id='tree-div2']//span[text()='attribute" . msq("textProductAttribute") . "']", "//*[@id='tree-div1']//span[text()='Product Details']/parent::*/parent::*/parent::*//li[1]//a/span"); // stepKey: dragAndDropToGroupProductDetailsAssignAttributeToGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignAttributeToGroup
		$I->see("attribute" . msq("textProductAttribute"), "#tree-div1"); // stepKey: seeAttributeInGroupAssignAttributeToGroup
		$I->comment("Exiting Action Group [assignAttributeToGroup] AssignAttributeToGroupActionGroup");
		$I->comment("Entering Action Group [saveAttributeSet] SaveAttributeSetActionGroup");
		$I->click("button[title='Save']"); // stepKey: clickSaveSaveAttributeSet
		$I->waitForPageLoad(30); // stepKey: clickSaveSaveAttributeSetWaitForPageLoad
		$I->see("You saved the attribute set", "#messages div.message-success"); // stepKey: successMessageSaveAttributeSet
		$I->comment("Exiting Action Group [saveAttributeSet] SaveAttributeSetActionGroup");
		$I->comment("Create product and fill new attribute field");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPage
		$I->comment("Entering Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-simple']", 30); // stepKey: waitForAddProductDropdownGoToCreateProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductTypeGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/simple/"); // stepKey: seeNewProductUrlGoToCreateProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateProduct
		$I->comment("Exiting Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillProductForm] FillMainProductFormNoWeightActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "SimpleProduct -+~/\\<>\’“:*\$#@()!,.?`=%&^"); // stepKey: fillProductNameFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "SimpleProduct" . msq("ProductWithSpecialSymbols")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillProductForm
		$I->fillField(".admin__field[data-index=qty] input", "1000"); // stepKey: fillProductQtyFillProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectWeightFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillMainProductFormNoWeightActionGroup");
		$I->comment("Entering Action Group [addCategoryToProduct] SetCategoryByNameActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: searchAndSelectCategoryAddCategoryToProduct
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategoryAddCategoryToProductWaitForPageLoad
		$I->comment("Exiting Action Group [addCategoryToProduct] SetCategoryByNameActionGroup");
		$I->fillField("//input[contains(@name, 'product[attribute" . msq("textProductAttribute") . "]')]", "searchable"); // stepKey: fillTheAttributeRequiredInputField
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Assert search results on storefront");
		$I->comment("Entering Action Group [goToStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefrontPage
		$I->comment("Exiting Action Group [goToStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [quickSearchForFirstSearchTerm] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "?searchable;"); // stepKey: fillInputQuickSearchForFirstSearchTerm
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchForFirstSearchTerm
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchForFirstSearchTerm
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchForFirstSearchTerm
		$I->seeInTitle("Search results for: '?searchable;'"); // stepKey: assertQuickSearchTitleQuickSearchForFirstSearchTerm
		$I->see("Search results for: '?searchable;'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchForFirstSearchTerm
		$I->comment("Exiting Action Group [quickSearchForFirstSearchTerm] StorefrontCheckQuickSearchStringActionGroup");
		$I->see("SimpleProduct -+~/\\<>\’“:*\$#@()!,.?`=%&^", ".product-item-name"); // stepKey: seeProductName
		$I->comment("Entering Action Group [quickSearchProductForSecondSearchTerm] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "? searchable ;"); // stepKey: fillInputQuickSearchProductForSecondSearchTerm
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchProductForSecondSearchTerm
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchProductForSecondSearchTerm
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchProductForSecondSearchTerm
		$I->seeInTitle("Search results for: '? searchable ;'"); // stepKey: assertQuickSearchTitleQuickSearchProductForSecondSearchTerm
		$I->see("Search results for: '? searchable ;'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchProductForSecondSearchTerm
		$I->comment("Exiting Action Group [quickSearchProductForSecondSearchTerm] StorefrontCheckQuickSearchStringActionGroup");
		$I->see("SimpleProduct -+~/\\<>\’“:*\$#@()!,.?`=%&^", ".product-item-name"); // stepKey: seeProductNameSecondTime
		$I->comment("Entering Action Group [quickSearchForSecondSearchTerm] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "?;"); // stepKey: fillInputQuickSearchForSecondSearchTerm
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchForSecondSearchTerm
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchForSecondSearchTerm
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchForSecondSearchTerm
		$I->seeInTitle("Search results for: '?;'"); // stepKey: assertQuickSearchTitleQuickSearchForSecondSearchTerm
		$I->see("Search results for: '?;'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchForSecondSearchTerm
		$I->comment("Exiting Action Group [quickSearchForSecondSearchTerm] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [checkEmptyForSecondSearchTerm] StorefrontCheckSearchIsEmptyActionGroup");
		$I->see("Your search returned no results", "div .message"); // stepKey: checkEmptyCheckEmptyForSecondSearchTerm
		$I->comment("Exiting Action Group [checkEmptyForSecondSearchTerm] StorefrontCheckSearchIsEmptyActionGroup");
		$I->comment("Entering Action Group [quickSearchProductForWithSpecialSymbols] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "?SimpleProduct -+~/\\<>\’“:*\$#@()!,.?`=%&^;"); // stepKey: fillInputQuickSearchProductForWithSpecialSymbols
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchProductForWithSpecialSymbols
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchProductForWithSpecialSymbols
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchProductForWithSpecialSymbols
		$I->seeInTitle("Search results for: '?SimpleProduct -+~/\\<>\’“:*\$#@()!,.?`=%&^;'"); // stepKey: assertQuickSearchTitleQuickSearchProductForWithSpecialSymbols
		$I->see("Search results for: '?SimpleProduct -+~/\\<>\’“:*\$#@()!,.?`=%&^;'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchProductForWithSpecialSymbols
		$I->comment("Exiting Action Group [quickSearchProductForWithSpecialSymbols] StorefrontCheckQuickSearchStringActionGroup");
		$I->see("SimpleProduct -+~/\\<>\’“:*\$#@()!,.?`=%&^", ".product-item-name"); // stepKey: seeProductWithSpecialSymbols
		$I->comment("Entering Action Group [quickSearchProductForWithSpecialSymbolsSecondTime] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "? SimpleProduct -+~/\\<>\’“:*\$#@()!,.?`=%&^ ;"); // stepKey: fillInputQuickSearchProductForWithSpecialSymbolsSecondTime
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchProductForWithSpecialSymbolsSecondTime
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchProductForWithSpecialSymbolsSecondTime
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchProductForWithSpecialSymbolsSecondTime
		$I->seeInTitle("Search results for: '? SimpleProduct -+~/\\<>\’“:*\$#@()!,.?`=%&^ ;'"); // stepKey: assertQuickSearchTitleQuickSearchProductForWithSpecialSymbolsSecondTime
		$I->see("Search results for: '? SimpleProduct -+~/\\<>\’“:*\$#@()!,.?`=%&^ ;'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchProductForWithSpecialSymbolsSecondTime
		$I->comment("Exiting Action Group [quickSearchProductForWithSpecialSymbolsSecondTime] StorefrontCheckQuickSearchStringActionGroup");
		$I->see("SimpleProduct -+~/\\<>\’“:*\$#@()!,.?`=%&^", ".product-item-name"); // stepKey: seeProductWithSpecialSymbolsSecondTime
		$I->comment("Entering Action Group [quickSearchForThirdSearchTerm] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "?anythingcangobetween;"); // stepKey: fillInputQuickSearchForThirdSearchTerm
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchForThirdSearchTerm
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchForThirdSearchTerm
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchForThirdSearchTerm
		$I->seeInTitle("Search results for: '?anythingcangobetween;'"); // stepKey: assertQuickSearchTitleQuickSearchForThirdSearchTerm
		$I->see("Search results for: '?anythingcangobetween;'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchForThirdSearchTerm
		$I->comment("Exiting Action Group [quickSearchForThirdSearchTerm] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [checkEmptyForThirdSearchTerm] StorefrontCheckSearchIsEmptyActionGroup");
		$I->see("Your search returned no results", "div .message"); // stepKey: checkEmptyCheckEmptyForThirdSearchTerm
		$I->comment("Exiting Action Group [checkEmptyForThirdSearchTerm] StorefrontCheckSearchIsEmptyActionGroup");
		$I->comment("Entering Action Group [quickSearchForForthSearchTerm] StorefrontCheckQuickSearchStringActionGroup");
		$I->fillField("#search", "? anything at all ;"); // stepKey: fillInputQuickSearchForForthSearchTerm
		$I->submitForm("#search", []); // stepKey: submitQuickSearchQuickSearchForForthSearchTerm
		$I->seeInCurrentUrl("/catalogsearch/result/"); // stepKey: checkUrlQuickSearchForForthSearchTerm
		$I->dontSeeInCurrentUrl("form_key="); // stepKey: checkUrlFormKeyQuickSearchForForthSearchTerm
		$I->seeInTitle("Search results for: '? anything at all ;'"); // stepKey: assertQuickSearchTitleQuickSearchForForthSearchTerm
		$I->see("Search results for: '? anything at all ;'", ".page-title span"); // stepKey: assertQuickSearchNameQuickSearchForForthSearchTerm
		$I->comment("Exiting Action Group [quickSearchForForthSearchTerm] StorefrontCheckQuickSearchStringActionGroup");
		$I->comment("Entering Action Group [checkEmptyForForthSearchTerm] StorefrontCheckSearchIsEmptyActionGroup");
		$I->see("Your search returned no results", "div .message"); // stepKey: checkEmptyCheckEmptyForForthSearchTerm
		$I->comment("Exiting Action Group [checkEmptyForForthSearchTerm] StorefrontCheckSearchIsEmptyActionGroup");
	}
}
