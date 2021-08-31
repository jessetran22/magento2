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
 * @Title("MC-11557: Check importing of configurable products with images present in filesystem")
 * @Description("Check importing of configurable products with images present in filesystem<h3>Test files</h3>app/code/Magento/CatalogImportExport/Test/Mftf/Test/AdminExportImportConfigurableProductWithImagesTest.xml<br>")
 * @TestCaseId("MC-11557")
 * @group configurable_product
 */
class AdminExportImportConfigurableProductWithImagesTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Add downloadable domains");
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add example.com static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->comment("Create sample data:
                 1. Create simple products");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createFirstSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createFirstSimpleProduct
		$I->createEntity("createSecondSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSecondSimpleProduct
		$I->comment("2. Create Downloadable product");
		$I->createEntity("createDownloadableProduct", "hook", "ApiDownloadableProduct", [], []); // stepKey: createDownloadableProduct
		$I->createEntity("addFirstDownloadableLink", "hook", "ApiDownloadableLink", ["createDownloadableProduct"], []); // stepKey: addFirstDownloadableLink
		$I->createEntity("addSecondDownloadableLink", "hook", "ApiDownloadableLink", ["createDownloadableProduct"], []); // stepKey: addSecondDownloadableLink
		$I->comment("3. Create Grouped product");
		$I->createEntity("createGroupedProduct", "hook", "ApiGroupedProduct", [], []); // stepKey: createGroupedProduct
		$I->createEntity("addProductOne", "hook", "OneSimpleProductLink", ["createGroupedProduct", "createFirstSimpleProduct"], []); // stepKey: addProductOne
		$I->comment("4. Create  configurable product with images");
		$I->createEntity("createExportImportCategory", "hook", "CategoryExportImport", [], []); // stepKey: createExportImportCategory
		$I->createEntity("createExportImportConfigurableProduct", "hook", "ApiConfigurableExportImportProduct", ["createExportImportCategory"], []); // stepKey: createExportImportConfigurableProduct
		$I->createEntity("createConfigurableProductWithImage", "hook", "ApiProductAttributeMediaGalleryForExportImport", ["createExportImportConfigurableProduct"], []); // stepKey: createConfigurableProductWithImage
		$I->createEntity("createExportImportConfigurableProductAttribute", "hook", "ProductAttributeWithTwoOptionsForExportImport", [], []); // stepKey: createExportImportConfigurableProductAttribute
		$I->createEntity("createExportImportConfigurableProductAttributeFirstOption", "hook", "ProductAttributeOptionOneForExportImport", ["createExportImportConfigurableProductAttribute"], []); // stepKey: createExportImportConfigurableProductAttributeFirstOption
		$I->createEntity("createExportImportConfigurableProductAttributeSecondOption", "hook", "ProductAttributeOptionTwoForExportImport", ["createExportImportConfigurableProductAttribute"], []); // stepKey: createExportImportConfigurableProductAttributeSecondOption
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createExportImportConfigurableProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeFirstOption", "hook", "ProductAttributeOptionGetter", ["createExportImportConfigurableProductAttribute"], null, 1); // stepKey: getConfigAttributeFirstOption
		$I->getEntity("getConfigAttributeSecondOption", "hook", "ProductAttributeOptionGetter", ["createExportImportConfigurableProductAttribute"], null, 2); // stepKey: getConfigAttributeSecondOption
		$I->createEntity("createConfigFirstChildProduct", "hook", "ApiSimpleOneExportImport", ["createExportImportConfigurableProductAttribute", "getConfigAttributeFirstOption"], []); // stepKey: createConfigFirstChildProduct
		$I->createEntity("addImageForFirstSimpleProduct", "hook", "ApiProductAttributeMediaGalleryForExportImport", ["createConfigFirstChildProduct"], []); // stepKey: addImageForFirstSimpleProduct
		$I->createEntity("createConfigSecondChildProduct", "hook", "ApiSimpleTwoExportImport", ["createExportImportConfigurableProductAttribute", "getConfigAttributeSecondOption"], []); // stepKey: createConfigSecondChildProduct
		$I->createEntity("addImageForSecondSimpleProduct", "hook", "ApiProductAttributeMediaGalleryEntryTestImage", ["createConfigSecondChildProduct"], []); // stepKey: addImageForSecondSimpleProduct
		$I->createEntity("createExportImportConfigurableProductTwoOption", "hook", "ConfigurableProductTwoOptions", ["createExportImportConfigurableProduct", "createExportImportConfigurableProductAttribute", "getConfigAttributeFirstOption", "getConfigAttributeSecondOption"], []); // stepKey: createExportImportConfigurableProductTwoOption
		$I->createEntity("addFirstExportImportConfigurableProductChild", "hook", "ConfigurableProductAddChild", ["createExportImportConfigurableProduct", "createConfigFirstChildProduct"], []); // stepKey: addFirstExportImportConfigurableProductChild
		$I->createEntity("addSecondExportImportConfigurableProductChild", "hook", "ConfigurableProductAddChild", ["createExportImportConfigurableProduct", "createConfigSecondChildProduct"], []); // stepKey: addSecondExportImportConfigurableProductChild
		$I->comment("5. Create configurable product");
		$I->createEntity("createConfigurableProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigurableProduct
		$I->createEntity("createConfigProductAttr", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttr
		$I->createEntity("createConfigProductAttributeOption", "hook", "productAttributeOption1", ["createConfigProductAttr"], []); // stepKey: createConfigProductAttributeOption
		$I->createEntity("createConfigAddToAttrSet", "hook", "AddToDefaultSet", ["createConfigProductAttr"], []); // stepKey: createConfigAddToAttrSet
		$I->getEntity("getConfigAttributeOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttr"], null, 1); // stepKey: getConfigAttributeOption
		$I->createEntity("createConfigChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttr", "getConfigAttributeOption", "createCategory"], []); // stepKey: createConfigChildProduct
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigurableProduct", "createConfigProductAttr", "getConfigAttributeOption"], []); // stepKey: createConfigProductOption
		$I->createEntity("addConfigurableProductChild", "hook", "ConfigurableProductAddChild", ["createConfigurableProduct", "createConfigChildProduct"], []); // stepKey: addConfigurableProductChild
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
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
		$I->comment("Remove downloadable domains");
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove example.com static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->comment("Delete created data");
		$I->deleteEntity("createFirstSimpleProduct", "hook"); // stepKey: deleteFisrtSimpleProduct
		$I->deleteEntity("createSecondSimpleProduct", "hook"); // stepKey: deleteSecondSimpleProduct
		$I->deleteEntity("createDownloadableProduct", "hook"); // stepKey: deleteDownloadableProduct
		$I->deleteEntity("createGroupedProduct", "hook"); // stepKey: deleteGroupedProduct
		$I->deleteEntity("createExportImportConfigurableProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createExportImportConfigurableProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->deleteEntity("createExportImportCategory", "hook"); // stepKey: deleteExportImportCategory
		$I->deleteEntity("createConfigFirstChildProduct", "hook"); // stepKey: deleteConfigFirstChildProduct
		$I->deleteEntity("createConfigSecondChildProduct", "hook"); // stepKey: deleteConfigSecondChildProduct
		$I->deleteEntity("createConfigurableProduct", "hook"); // stepKey: deleteConfigurableProduct
		$I->deleteEntity("createConfigChildProduct", "hook"); // stepKey: deleteConfigChildProduct
		$I->deleteEntity("createConfigProductAttr", "hook"); // stepKey: deleteConfigProductAttr
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersResetProductGridColumnsInitialWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabResetProductGridColumnsInitial
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitial
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewResetProductGridColumnsInitialWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadResetProductGridColumnsInitial
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedResetProductGridColumnsInitial
		$I->comment("Exiting Action Group [resetProductGridColumnsInitial] ResetProductGridToDefaultViewActionGroup");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
		$I->comment("Admin logout");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"CatalogImportExport"})
	 * @Stories({"Export/Import products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminExportImportConfigurableProductWithImagesTest(AcceptanceTester $I)
	{
		$I->comment("Go to System > Export");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/export/"); // stepKey: goToExportIndexPage
		$I->comment("Set Export Settings: Entity Type > Products, SKU > ConfProd's sku and press \"Continue\"");
		$I->comment("Entering Action Group [exportProductBySku] ExportProductsFilterByAttributeActionGroup");
		$I->waitForElementVisible("#entity", 30); // stepKey: waitForEntityTypeDropDownExportProductBySku
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionExportProductBySku
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadExportProductBySku
		$I->waitForElementVisible("#export_filter_form", 30); // stepKey: waitForElementVisibleExportProductBySku
		$I->scrollTo("//*[@name='export_filter[sku]']/ancestor::tr//input[@type='checkbox']"); // stepKey: scrollToAttributeExportProductBySku
		$I->checkOption("//*[@name='export_filter[sku]']/ancestor::tr//input[@type='checkbox']"); // stepKey: selectAttributeExportProductBySku
		$I->fillField("//*[@name='export_filter[sku]']/ancestor::tr//input[@type='text']", $I->retrieveEntityField('createExportImportConfigurableProduct', 'sku', 'test')); // stepKey: setDataInFieldExportProductBySku
		$I->waitForPageLoad(30); // stepKey: waitForUserInputExportProductBySku
		$I->scrollTo("//*[@id='export_filter_container']/button"); // stepKey: scrollToContinueExportProductBySku
		$I->waitForPageLoad(30); // stepKey: scrollToContinueExportProductBySkuWaitForPageLoad
		$I->click("//*[@id='export_filter_container']/button"); // stepKey: clickContinueButtonExportProductBySku
		$I->waitForPageLoad(30); // stepKey: clickContinueButtonExportProductBySkuWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickExportProductBySku
		$I->waitForText("Message is added to queue, wait to get your file soon", 30, "#messages div.message-success"); // stepKey: seeSuccessMessageExportProductBySku
		$I->comment("Exiting Action Group [exportProductBySku] ExportProductsFilterByAttributeActionGroup");
		$I->comment("Start message queue for export consumer");
		$I->comment("Entering Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$startMessageQueueStartMessageQueue = $I->magentoCLI("queue:consumers:start exportProcessor --max-messages=100", 60); // stepKey: startMessageQueueStartMessageQueue
		$I->comment($startMessageQueueStartMessageQueue);
		$I->comment("Exiting Action Group [startMessageQueue] CliConsumerStartActionGroup");
		$I->reloadPage(); // stepKey: refreshPage
		$I->waitForElementVisible("[data-role='grid'] tr[data-repeat-index='0'] div.data-grid-cell-content", 30); // stepKey: waitForFileName
		$getFilename = $I->grabTextFrom("[data-role='grid'] tr[data-repeat-index='0'] div.data-grid-cell-content"); // stepKey: getFilename
		$I->comment("Entering Action Group [grabNameFile] AdminGetExportFilenameOnServerActionGroup");
		$I->waitForElementVisible("//tr[@data-repeat-index='0']//button", 30); // stepKey: waitForTheRowGrabNameFile
		$I->waitForPageLoad(30); // stepKey: waitForTheRowGrabNameFileWaitForPageLoad
		$grabDownloadUrlGrabNameFile = $I->grabAttributeFrom("//tr[@data-repeat-index='0']//a[text()='Download']", "href"); // stepKey: grabDownloadUrlGrabNameFile
		$I->waitForPageLoad(30); // stepKey: grabDownloadUrlGrabNameFileWaitForPageLoad
		$grabFilenameGrabNameFile = $I->executeJS("var href = '{$grabDownloadUrlGrabNameFile}';  return href.toQueryParams().filename;"); // stepKey: grabFilenameGrabNameFile
		$grabNameFile = $I->return($grabFilenameGrabNameFile); // stepKey: returnFilenameGrabNameFile
		$I->comment("Exiting Action Group [grabNameFile] AdminGetExportFilenameOnServerActionGroup");
		$I->comment("Save exported file: file successfully downloaded");
		$I->comment("Entering Action Group [downloadCreatedProducts] DownloadFileActionGroup");
		$I->reloadPage(); // stepKey: refreshPageDownloadCreatedProducts
		$I->waitForPageLoad(30); // stepKey: waitFormReloadDownloadCreatedProducts
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//button[@class='action-select']"); // stepKey: clickSelectBtnDownloadCreatedProducts
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//a[text()='Download']"); // stepKey: clickOnDownloadDownloadCreatedProducts
		$I->waitForPageLoad(30); // stepKey: clickOnDownloadDownloadCreatedProductsWaitForPageLoad
		$I->comment("Exiting Action Group [downloadCreatedProducts] DownloadFileActionGroup");
		$I->comment("Go to Catalog > Products. Find ConfProd and delete it");
		$I->comment("Entering Action Group [deleteConfigurableProductBySku] DeleteProductBySkuActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteConfigurableProductBySku
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersDeleteConfigurableProductBySku
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteConfigurableProductBySkuWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteConfigurableProductBySku
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createExportImportConfigurableProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterDeleteConfigurableProductBySku
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteConfigurableProductBySku
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteConfigurableProductBySkuWaitForPageLoad
		$I->see($I->retrieveEntityField('createExportImportConfigurableProduct', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteConfigurableProductBySku
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteConfigurableProductBySku
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteConfigurableProductBySku
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteConfigurableProductBySku
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteConfigurableProductBySkuWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteConfigurableProductBySku
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteConfigurableProductBySkuWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForConfirmModalDeleteConfigurableProductBySku
		$I->waitForPageLoad(60); // stepKey: waitForConfirmModalDeleteConfigurableProductBySkuWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmProductDeleteDeleteConfigurableProductBySku
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteConfigurableProductBySkuWaitForPageLoad
		$I->see("record(s) have been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteConfigurableProductBySku
		$I->comment("Exiting Action Group [deleteConfigurableProductBySku] DeleteProductBySkuActionGroup");
		$I->comment("Go to System > Import. Set import settings: Entity Type > Product, Import Behavior > Add/Update,
             Select File to Import > previously exported file and press \"Check Data\"");
		$I->comment("Entering Action Group [adminImportProduct] AdminImportProductsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: goToImportIndexPageAdminImportProduct
		$I->waitForPageLoad(30); // stepKey: adminImportMainSectionLoadAdminImportProduct
		$I->selectOption("#entity", "Products"); // stepKey: selectProductsOptionAdminImportProduct
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorElementVisibleAdminImportProduct
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionAdminImportProduct
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionAdminImportProduct
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldAdminImportProduct
		$I->attachFile("#import_file", "export_import_configurable_product.csv"); // stepKey: attachFileForImportAdminImportProduct
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonAdminImportProduct
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonAdminImportProductWaitForPageLoad
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonAdminImportProduct
		$I->waitForPageLoad(30); // stepKey: clickImportButtonAdminImportProductWaitForPageLoad
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageAdminImportProduct
		$I->see("Created: 1, Updated: 0, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessageAdminImportProduct
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessageAdminImportProduct
		$I->comment("Exiting Action Group [adminImportProduct] AdminImportProductsActionGroup");
		$I->comment("Go to Catalog > Products: Configurable product exists");
		$I->comment("Entering Action Group [openConfigurableProduct] FilterAndSelectProductActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageOpenConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadOpenConfigurableProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersOpenConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersOpenConfigurableProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersOpenConfigurableProduct
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createExportImportConfigurableProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterOpenConfigurableProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersOpenConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersOpenConfigurableProductWaitForPageLoad
		$I->waitForElementNotVisible(".admin__data-grid-loading-mask[data-component*='product_listing']", 30); // stepKey: waitForFilteredGridLoadOpenConfigurableProduct
		$I->click("//td[count(../../..//th[./*[.='SKU']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('createExportImportConfigurableProduct', 'sku', 'test') . "']]"); // stepKey: openSelectedProductOpenConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductToLoadOpenConfigurableProduct
		$I->waitForElementVisible(".page-header h1.page-title", 30); // stepKey: waitForProductTitleOpenConfigurableProduct
		$I->comment("Exiting Action Group [openConfigurableProduct] FilterAndSelectProductActionGroup");
		$I->comment("Go to \"Configurations\" section: configurations exist and have images");
		$I->seeNumberOfElements(".data-row", "2"); // stepKey: seeNumberOfRows
		$I->see($I->retrieveEntityField('createConfigFirstChildProduct', 'name', 'test'), ".admin__control-fields[data-index='name_container']"); // stepKey: seeFirstProductNameInField
		$I->see($I->retrieveEntityField('createConfigSecondChildProduct', 'name', 'test'), ".admin__control-fields[data-index='name_container']"); // stepKey: seeSecondProductNameInField
		$I->see($I->retrieveEntityField('createConfigFirstChildProduct', 'sku', 'test'), ".admin__control-fields[data-index='sku_container']"); // stepKey: seeFirstProductSkuInField
		$I->see($I->retrieveEntityField('createConfigSecondChildProduct', 'sku', 'test'), ".admin__control-fields[data-index='sku_container']"); // stepKey: seeSecondProductSkuInField
		$I->see($I->retrieveEntityField('createConfigFirstChildProduct', 'price', 'test'), ".admin__control-fields[data-index='price_container']"); // stepKey: seeFirstProductPriceInField
		$I->see($I->retrieveEntityField('createConfigSecondChildProduct', 'price', 'test'), ".admin__control-fields[data-index='price_container']"); // stepKey: seeSecondProductPriceInField
		$I->seeElement("[data-index='configurable-matrix'] [data-index='thumbnail_image_container'] img[src*='magento-logo']"); // stepKey: seeFirstProductImageInField
		$I->seeElement("[data-index='configurable-matrix'] [data-index='thumbnail_image_container'] img[src*='test_image']"); // stepKey: seeSecondProductImageInField
		$I->comment("Go to \"Images and Videos\" section: assert image");
		$I->scrollTo(".admin__collapsible-block-wrapper[data-index='configurable']"); // stepKey: scrollToProductGalleryTab
		$I->comment("Entering Action Group [assertProductImageAdminProductPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProductImageAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductImageAdminProductPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertProductImageAdminProductPage
		$I->comment("Exiting Action Group [assertProductImageAdminProductPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->comment("Go to any ConfProd's configuration page: Product page open successfully");
		$I->click("//div[@data-index='configurable-matrix']//*[@data-index='name_container']//a[contains(text(), '" . $I->retrieveEntityField('createConfigFirstChildProduct', 'name', 'test') . "')]"); // stepKey: clickOnFirstProductLink
		$I->switchToNextTab(); // stepKey: switchToConfigChildProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Go to \"Images and Videos\" section: assert image");
		$I->scrollTo(".admin__collapsible-block-wrapper[data-index='configurable']"); // stepKey: scrollToChildProductGalleryTab
		$I->comment("Entering Action Group [assertChildProductImageAdminProductPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertChildProductImageAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertChildProductImageAdminProductPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertChildProductImageAdminProductPage
		$I->comment("Exiting Action Group [assertChildProductImageAdminProductPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->closeTab(); // stepKey: closeConfigChildProductPage
		$I->comment("Delete exported file");
		$I->comment("Entering Action Group [deleteExportedFile] DeleteExportedFileActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/export/"); // stepKey: goToExportIndexPageDeleteExportedFile
		$I->waitForPageLoad(30); // stepKey: waitFormReloadDeleteExportedFile
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//button[@class='action-select']"); // stepKey: clickSelectBtnDeleteExportedFile
		$I->click("//div[@class='data-grid-cell-content'][text()='{$getFilename}']/../..//a[text()='Delete']"); // stepKey: clickOnDeleteDeleteExportedFile
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteDeleteExportedFileWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteExportedFile
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmDeleteDeleteExportedFile
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteExportedFileWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitFormReload2DeleteExportedFile
		$I->dontSeeElement("//div[@class='data-grid-cell-content'][text()='{$getFilename}']"); // stepKey: assertDontSeeFileDeleteExportedFile
		$I->comment("Exiting Action Group [deleteExportedFile] DeleteExportedFileActionGroup");
	}
}
