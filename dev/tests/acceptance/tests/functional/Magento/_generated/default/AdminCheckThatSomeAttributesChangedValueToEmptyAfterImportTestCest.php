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
 * @Title("MC-11332: Check that some attributes changed the value to an empty after import CSV")
 * @Description("Check that some attributes changed the value to an empty after import CSV<h3>Test files</h3>app/code/Magento/ImportExport/Test/Mftf/Test/AdminCheckThatSomeAttributesChangedValueToEmptyAfterImportTest.xml<br>")
 * @TestCaseId("MC-11332")
 * @group importExport
 */
class AdminCheckThatSomeAttributesChangedValueToEmptyAfterImportTestCest
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
		$I->comment("Entering Action Group [navigateToProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndexPage
		$I->comment("Exiting Action Group [navigateToProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetProductGridToDefaultView] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridToDefaultViewWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGridToDefaultView
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridToDefaultViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGridToDefaultView
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGridToDefaultView
		$I->comment("Exiting Action Group [resetProductGridToDefaultView] ResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [deleteAllProducts] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteAllProducts
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteAllProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteAllProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteAllProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteAllProductsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteAllProductsWaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteAllProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteAllProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteAllProducts
		$I->comment("Exiting Action Group [deleteAllProducts] DeleteProductsIfTheyExistActionGroup");
		$I->createEntity("productAttribute", "hook", "productDropDownAttribute", [], []); // stepKey: productAttribute
		$I->createEntity("attributeOptionWithDefaultValue", "hook", "productAttributeOption2", ["productAttribute"], []); // stepKey: attributeOptionWithDefaultValue
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete Product and Category");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [deleteProduct1] DeleteProductActionGroup");
		$I->click("#menu-magento-catalog-catalog"); // stepKey: openCatalogDeleteProduct1
		$I->waitForPageLoad(5); // stepKey: waitForCatalogSubmenuDeleteProduct1
		$I->click("//li[@id='menu-magento-catalog-catalog']//li[@data-ui-id='menu-magento-catalog-catalog-products']"); // stepKey: clickOnProductsDeleteProduct1
		$I->waitForPageLoad(10); // stepKey: waitForProductsPageDeleteProduct1
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteProduct1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteProduct1WaitForPageLoad
		$I->click("//*[contains(text(),'Test_Product')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']"); // stepKey: TickCheckboxDeleteProduct1
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageDeleteProduct1
		$I->click("//div[@class='col-xs-2']/div[@class='action-select-wrap']/button[@class='action-select']"); // stepKey: OpenActionsDeleteProduct1
		$I->waitForAjaxLoad(5); // stepKey: waitForDeleteDeleteProduct1
		$I->click("//*[contains(@class,'admin__data-grid-header-row row row-gutter')]//*[text()='Delete']"); // stepKey: ChooseDeleteDeleteProduct1
		$I->waitForPageLoad(10); // stepKey: waitForDeleteItemPopupDeleteProduct1
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: clickOnOkDeleteProduct1
		$I->waitForElementVisible("//*[@class='message message-success success']", 10); // stepKey: waitForSuccessfullyDeletedMessageDeleteProduct1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappearDeleteProduct1
		$I->comment("Exiting Action Group [deleteProduct1] DeleteProductActionGroup");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete attribute");
		$I->deleteEntity("productAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"ImportExport"})
	 * @Stories({"Attribute importing"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckThatSomeAttributesChangedValueToEmptyAfterImportTest(AcceptanceTester $I)
	{
		$I->comment("Create product");
		$I->comment("Entering Action Group [openProductFillForm] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("actionGroup:GoToSpecifiedCreateProductPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexOpenProductFillForm
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductDropdownOpenProductFillForm
		$I->waitForPageLoad(30); // stepKey: clickAddProductDropdownOpenProductFillFormWaitForPageLoad
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-simple']"); // stepKey: clickAddProductOpenProductFillForm
		$I->waitForPageLoad(30); // stepKey: waitForFormToLoadOpenProductFillForm
		$I->comment("Exiting Action Group [openProductFillForm] GoToSpecifiedCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillProductFieldsInAdmin] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=name] input", "Test_Product"); // stepKey: fillProductNameFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=sku] input", "test_sku"); // stepKey: fillProductSkuFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=price] input", "560.00"); // stepKey: fillProductPriceFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=qty] input", "25"); // stepKey: fillProductQtyFillProductFieldsInAdmin
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillProductFieldsInAdmin
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillProductFieldsInAdminWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillProductFieldsInAdmin
		$I->fillField(".admin__field[data-index=weight] input", "1"); // stepKey: fillProductWeightFillProductFieldsInAdmin
		$I->comment("Exiting Action Group [fillProductFieldsInAdmin] FillMainProductFormActionGroup");
		$I->comment("Entering Action Group [addCategoryToProduct] SetCategoryByNameActionGroup");
		$I->searchAndMultiSelectOption("div[data-index='category_ids']", [$I->retrieveEntityField('createCategory', 'name', 'test')]); // stepKey: searchAndSelectCategoryAddCategoryToProduct
		$I->waitForPageLoad(30); // stepKey: searchAndSelectCategoryAddCategoryToProductWaitForPageLoad
		$I->comment("Exiting Action Group [addCategoryToProduct] SetCategoryByNameActionGroup");
		$I->comment("Select created attribute");
		$I->comment("Entering Action Group [addAttributeToProduct] AddProductAttributeInProductModalActionGroup");
		$I->click("#addAttribute"); // stepKey: addAttributeAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: addAttributeAddAttributeToProductWaitForPageLoad
		$I->conditionalClick(".product_form_product_form_add_attribute_modal .action-clear", ".product_form_product_form_add_attribute_modal .action-clear", true); // stepKey: clearFiltersAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clearFiltersAddAttributeToProductWaitForPageLoad
		$I->click(".product_form_product_form_add_attribute_modal button[data-action='grid-filter-expand']"); // stepKey: clickFiltersAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickFiltersAddAttributeToProductWaitForPageLoad
		$I->fillField(".product_form_product_form_add_attribute_modal input[name='attribute_code']", $I->retrieveEntityField('productAttribute', 'attribute_code', 'test')); // stepKey: fillCodeAddAttributeToProduct
		$I->click(".product_form_product_form_add_attribute_modal .admin__data-grid-filters-footer .action-secondary"); // stepKey: clickApplyAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyAddAttributeToProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAddAttributeToProduct
		$I->checkOption(".product_form_product_form_add_attribute_modal .data-grid-checkbox-cell input"); // stepKey: checkAttributeAddAttributeToProduct
		$I->click(".product_form_product_form_add_attribute_modal .page-main-actions .action-primary"); // stepKey: addSelectedAddAttributeToProduct
		$I->waitForPageLoad(30); // stepKey: addSelectedAddAttributeToProductWaitForPageLoad
		$I->comment("Exiting Action Group [addAttributeToProduct] AddProductAttributeInProductModalActionGroup");
		$I->comment("Check that attribute value is selected");
		$I->scrollTo("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Attributes']"); // stepKey: scrollToAttributeTitle1
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Attributes']", "//select[@name='product[" . $I->retrieveEntityField('productAttribute', 'attribute_code', 'test') . "]']", false); // stepKey: expandAttributeTab1
		$I->waitForPageLoad(30); // stepKey: expandAttributeTab1WaitForPageLoad
		$I->seeOptionIsSelected("//select[@name='product[" . $I->retrieveEntityField('productAttribute', 'attribute_code', 'test') . "]']", "option2"); // stepKey: seeAttributeValueIsSelected1
		$I->waitForPageLoad(30); // stepKey: seeAttributeValueIsSelected1WaitForPageLoad
		$I->comment("Entering Action Group [saveProduct] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct
		$I->comment("Exiting Action Group [saveProduct] SaveProductFormActionGroup");
		$I->comment("Import product with add/update behavior");
		$I->comment("Entering Action Group [adminImportProductsFirstTime] AdminImportProductsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageAdminImportProductsFirstTime
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadAdminImportProductsFirstTime
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionAdminImportProductsFirstTime
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleAdminImportProductsFirstTime
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionAdminImportProductsFirstTime
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionAdminImportProductsFirstTime
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldAdminImportProductsFirstTime
		$I->attachFile("#import_file", "import_simple_product.csv"); // stepKey: attachFileForImportAdminImportProductsFirstTime
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonAdminImportProductsFirstTime
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonAdminImportProductsFirstTimeWaitForPageLoad
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonAdminImportProductsFirstTime
		$I->waitForPageLoad(30); // stepKey: clickImportButtonAdminImportProductsFirstTimeWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageAdminImportProductsFirstTime
		$I->see("Created: 0, Updated: 1, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageAdminImportProductsFirstTime
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageAdminImportProductsFirstTime
		$I->comment("Exiting Action Group [adminImportProductsFirstTime] AdminImportProductsActionGroup");
		$I->comment("Check that attribute value is empty after import");
		$I->comment("Entering Action Group [filterAndSelectTheProduct2] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageFilterAndSelectTheProduct2
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadFilterAndSelectTheProduct2
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersFilterAndSelectTheProduct2
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersFilterAndSelectTheProduct2WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersFilterAndSelectTheProduct2
		$I->fillField("input.admin__control-text[name='sku']", "test_sku"); // stepKey: fillProductSkuFilterFilterAndSelectTheProduct2
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersFilterAndSelectTheProduct2
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersFilterAndSelectTheProduct2WaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadFilterAndSelectTheProduct2
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='test_sku']]"); // stepKey: openSelectedProductFilterAndSelectTheProduct2
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadFilterAndSelectTheProduct2
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleFilterAndSelectTheProduct2
		$I->comment("Exiting Action Group [filterAndSelectTheProduct2] FilterAndSelectProductActionGroup");
		$I->scrollTo("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Attributes']"); // stepKey: scrollToAttributeTitle2
		$I->conditionalClick("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Attributes']", "//select[@name='product[" . $I->retrieveEntityField('productAttribute', 'attribute_code', 'test') . "]']", false); // stepKey: expandAttributeTab2
		$I->waitForPageLoad(30); // stepKey: expandAttributeTab2WaitForPageLoad
		$I->seeOptionIsSelected("//select[@name='product[" . $I->retrieveEntityField('productAttribute', 'attribute_code', 'test') . "]']", ""); // stepKey: seeAttributeValueIsSelected2
		$I->waitForPageLoad(30); // stepKey: seeAttributeValueIsSelected2WaitForPageLoad
	}
}
