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
 * @Title("MC-38432: Import Bundle Product")
 * @Description("Imports a .csv file containing a bundle product. Verifies that product is imported             successfully and can be purchased.<h3>Test files</h3>app/code/Magento/BundleImportExport/Test/Mftf/Test/AdminImportBundleProductTest.xml<br>")
 * @TestCaseId("MC-38432")
 * @group importExport
 * @group Bundle
 */
class AdminImportBundleProductTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create Product, Upload Images & Create Customer");
		$I->createEntity("createImportCategory", "hook", "ImportCategory_Bundle", [], []); // stepKey: createImportCategory
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Copy Images to Import Directory for Product Images");
		$I->comment('[createDirectoryForImportImages] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::createDirectory()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->createDirectory("var/import/images/import-product-bundle", 511); // stepKey: createDirectoryForImportImages
		$I->comment('[copyProduct1BaseImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/magento-logo.png", "var/import/images/import-product-bundle/magento-logo.png"); // stepKey: copyProduct1BaseImage
		$I->comment('[copyProduct2BaseImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/m-logo.gif", "var/import/images/import-product-bundle/m-logo.gif"); // stepKey: copyProduct2BaseImage
		$I->comment('[copyProduct3BaseImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/adobe-base.jpg", "var/import/images/import-product-bundle/adobe-base.jpg"); // stepKey: copyProduct3BaseImage
		$I->comment("Login as Admin");
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
		$I->comment("Delete Data");
		$I->deleteEntity("createImportCategory", "hook"); // stepKey: deleteImportCategory
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment('[deleteProductImageDirectory] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::deleteDirectory()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->deleteDirectory("var/import/images/import-product-bundle"); // stepKey: deleteProductImageDirectory
		$I->deleteEntityByUrl("/V1/products/import-product-simple1-bundle"); // stepKey: deleteImportedSimpleProduct1
		$I->deleteEntityByUrl("/V1/products/import-product-simple2-bundle"); // stepKey: deleteImportedSimpleProduct2
		$I->deleteEntityByUrl("/V1/products/import-product-simple3-bundle"); // stepKey: deleteImportedSimpleProduct3
		$I->deleteEntityByUrl("/V1/products/import-product-bundle"); // stepKey: deleteImportedBundleProduct
		$I->comment("Entering Action Group [navigateToAndResetProductGridToDefaultView] NavigateToAndResetProductGridToDefaultViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageNavigateToAndResetProductGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadNavigateToAndResetProductGridToDefaultView
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersNavigateToAndResetProductGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersNavigateToAndResetProductGridToDefaultViewWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabNavigateToAndResetProductGridToDefaultView
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewNavigateToAndResetProductGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewNavigateToAndResetProductGridToDefaultViewWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductGridLoadNavigateToAndResetProductGridToDefaultView
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedNavigateToAndResetProductGridToDefaultView
		$I->comment("Exiting Action Group [navigateToAndResetProductGridToDefaultView] NavigateToAndResetProductGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Features({"BundleImportExport"})
	 * @Stories({"Import Products"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminImportBundleProductTest(AcceptanceTester $I)
	{
		$I->comment("Import Bundle Product & Assert No Errors");
		$I->comment("Entering Action Group [navigateToImportPage] AdminNavigateToImportPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/import/"); // stepKey: navigateToImportPageNavigateToImportPage
		$I->comment("Exiting Action Group [navigateToImportPage] AdminNavigateToImportPageActionGroup");
		$I->comment("Entering Action Group [fillImportForm] AdminFillImportFormActionGroup");
		$I->waitForElementVisible("#entity", 30); // stepKey: waitForEntityTypeFillImportForm
		$I->selectOption("#entity", "Products"); // stepKey: selectEntityTypeFillImportForm
		$I->waitForElementVisible("#basic_behavior", 30); // stepKey: waitForImportBehaviorFillImportForm
		$I->selectOption("#basic_behavior", "Add/Update"); // stepKey: selectImportBehaviorOptionFillImportForm
		$I->selectOption("#basic_behaviorvalidation_strategy", "Stop on Error"); // stepKey: selectValidationStrategyOptionFillImportForm
		$I->fillField("#basic_behavior_allowed_error_count", "10"); // stepKey: fillAllowedErrorsCountFieldFillImportForm
		$I->fillField("#basic_behavior__import_field_separator", ","); // stepKey: fillFieldSeparatorFieldFillImportForm
		$I->fillField("#basic_behavior_import_multiple_value_separator", ","); // stepKey: fillMultipleValueSeparatorFieldFillImportForm
		$I->fillField("#basic_behavior_import_empty_attribute_value_constant", "__EMPTY__VALUE__"); // stepKey: fillEmptyAttributeValueConstantFieldFillImportForm
		$I->attachFile("#import_file", "import_bundle_product.csv"); // stepKey: attachFileForImportFillImportForm
		$I->fillField("#import_images_file_dir", "import-product-bundle"); // stepKey: fillImagesFileDirectoryFieldFillImportForm
		$I->comment("Exiting Action Group [fillImportForm] AdminFillImportFormActionGroup");
		$I->comment("Entering Action Group [clickCheckData] AdminClickCheckDataImportActionGroup");
		$I->waitForElementVisible("#upload_button", 30); // stepKey: waitForCheckDataButtonClickCheckData
		$I->waitForPageLoad(30); // stepKey: waitForCheckDataButtonClickCheckDataWaitForPageLoad
		$I->click("#upload_button"); // stepKey: clickCheckDataButtonClickCheckData
		$I->waitForPageLoad(30); // stepKey: clickCheckDataButtonClickCheckDataWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickCheckData
		$I->comment("Exiting Action Group [clickCheckData] AdminClickCheckDataImportActionGroup");
		$I->see("File is valid! To start import process press \"Import\" button", "#import_validation_messages .message-success"); // stepKey: seeCheckDataResultMessage
		$I->dontSeeElementInDOM("#import_validation_messages .import-error-list"); // stepKey: dontSeeErrorMessage
		$I->comment("Entering Action Group [clickImport] AdminClickImportActionGroup");
		$I->waitForElementVisible("#import_validation_container button", 30); // stepKey: waitForImportButtonClickImport
		$I->waitForPageLoad(30); // stepKey: waitForImportButtonClickImportWaitForPageLoad
		$I->click("#import_validation_container button"); // stepKey: clickImportButtonClickImport
		$I->waitForPageLoad(30); // stepKey: clickImportButtonClickImportWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickImport
		$I->waitForElementVisible("#import_validation_messages .message-notice", 30); // stepKey: waitForNoticeMessageClickImport
		$I->comment("Exiting Action Group [clickImport] AdminClickImportActionGroup");
		$I->see("Created: 4, Updated: 0, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessage
		$I->see("Import successfully done", "#import_validation_messages .message-success"); // stepKey: seeImportMessage
		$I->dontSeeElementInDOM("#import_validation_messages .import-error-list"); // stepKey: dontSeeErrorMessage2
		$I->comment("Reindex");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, ""); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Admin: Verify Data on Import History Page");
		$I->comment("Entering Action Group [navigateToImportHistoryPage] AdminNavigateToImportHistoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/history"); // stepKey: navigateToImportHistoryPageNavigateToImportHistoryPage
		$I->comment("Exiting Action Group [navigateToImportHistoryPage] AdminNavigateToImportHistoryPageActionGroup");
		$I->comment("Entering Action Group [sortColumnByIdDescending] AdminGridSortColumnDescendingActionGroup");
		$I->conditionalClick("th[data-sort='history_id']", "th[data-sort='history_id'].not-sort", true); // stepKey: clickColumnIfNotSortedSortColumnByIdDescending
		$I->waitForPageLoad(30); // stepKey: waitForGridLoad1SortColumnByIdDescending
		$I->conditionalClick("th[data-sort='history_id']", "th[data-sort='history_id']._ascend", true); // stepKey: clickColumnIfAscendingSortColumnByIdDescending
		$I->waitForPageLoad(30); // stepKey: waitForGridLoad2SortColumnByIdDescending
		$I->waitForElementVisible("th[data-sort='history_id']._descend", 30); // stepKey: seeColumnDescendingSortColumnByIdDescending
		$I->comment("Exiting Action Group [sortColumnByIdDescending] AdminGridSortColumnDescendingActionGroup");
		$I->see("import_bundle_product.csv", "table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: seeImportedFile
		$I->waitForPageLoad(60); // stepKey: seeImportedFileWaitForPageLoad
		$I->see("Created: 4, Updated: 0, Deleted: 0", "table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: seeSummary
		$I->waitForPageLoad(60); // stepKey: seeSummaryWaitForPageLoad
		$I->comment("Admin: Verify Simple Product 1 on Edit Product Page");
		$I->comment("Entering Action Group [goToSimpleProduct1EditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageGoToSimpleProduct1EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadGoToSimpleProduct1EditPage
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersGoToSimpleProduct1EditPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersGoToSimpleProduct1EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersGoToSimpleProduct1EditPage
		$I->dontSeeElement(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: dontSeeClearFiltersGoToSimpleProduct1EditPage
		$I->waitForPageLoad(30); // stepKey: dontSeeClearFiltersGoToSimpleProduct1EditPageWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabGoToSimpleProduct1EditPage
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewGoToSimpleProduct1EditPage
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewGoToSimpleProduct1EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetToDefaultViewGoToSimpleProduct1EditPage
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedGoToSimpleProduct1EditPage
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersGoToSimpleProduct1EditPage
		$I->fillField("input.admin__control-text[name='sku']", "import-product-simple1-bundle"); // stepKey: fillProductSkuFilterGoToSimpleProduct1EditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToSimpleProduct1EditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToSimpleProduct1EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToSimpleProduct1EditPage
		$I->click("//td/div[text()='import-product-simple1-bundle']"); // stepKey: clickProductGoToSimpleProduct1EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToSimpleProduct1EditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToSimpleProduct1EditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-simple1-bundle"); // stepKey: seeProductSKUGoToSimpleProduct1EditPage
		$I->comment("Exiting Action Group [goToSimpleProduct1EditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct1OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertSimpleProduct1OnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertSimpleProduct1OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertSimpleProduct1OnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-simple1-bundle"); // stepKey: seeProductNameAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-simple1-bundle"); // stepKey: seeProductSkuAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "10.00"); // stepKey: seeProductPriceAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "101"); // stepKey: seeProductQuantityAssertSimpleProduct1OnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertSimpleProduct1OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertSimpleProduct1OnEditPageWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", "1"); // stepKey: seeProductWeightAssertSimpleProduct1OnEditPage
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeProductVisibilityAssertSimpleProduct1OnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-bundle')]"); // stepKey: seeProductCategoriesAssertSimpleProduct1OnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct1OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct1ImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertSimpleProduct1ImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSimpleProduct1ImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertSimpleProduct1ImageOnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct1ImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='image']"); // stepKey: seeBaseImageRoleSimple1
		$I->comment("Entering Action Group [assertSimpleProduct1SmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertSimpleProduct1SmallImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSimpleProduct1SmallImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertSimpleProduct1SmallImageOnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct1SmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='small_image']"); // stepKey: seeSmallImageRoleSimple1
		$I->comment("Entering Action Group [assertSimpleProduct1ThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertSimpleProduct1ThumbnailImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSimpleProduct1ThumbnailImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertSimpleProduct1ThumbnailImageOnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct1ThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='thumbnail']"); // stepKey: seeThumbnailImageRoleSimple1
		$I->comment("Admin: Verify Simple Product 2 on Edit Product Page");
		$I->comment("Entering Action Group [goToSimpleProduct2EditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageGoToSimpleProduct2EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadGoToSimpleProduct2EditPage
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersGoToSimpleProduct2EditPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersGoToSimpleProduct2EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersGoToSimpleProduct2EditPage
		$I->dontSeeElement(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: dontSeeClearFiltersGoToSimpleProduct2EditPage
		$I->waitForPageLoad(30); // stepKey: dontSeeClearFiltersGoToSimpleProduct2EditPageWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabGoToSimpleProduct2EditPage
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewGoToSimpleProduct2EditPage
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewGoToSimpleProduct2EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetToDefaultViewGoToSimpleProduct2EditPage
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedGoToSimpleProduct2EditPage
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersGoToSimpleProduct2EditPage
		$I->fillField("input.admin__control-text[name='sku']", "import-product-simple2-bundle"); // stepKey: fillProductSkuFilterGoToSimpleProduct2EditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToSimpleProduct2EditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToSimpleProduct2EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToSimpleProduct2EditPage
		$I->click("//td/div[text()='import-product-simple2-bundle']"); // stepKey: clickProductGoToSimpleProduct2EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToSimpleProduct2EditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToSimpleProduct2EditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-simple2-bundle"); // stepKey: seeProductSKUGoToSimpleProduct2EditPage
		$I->comment("Exiting Action Group [goToSimpleProduct2EditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct2OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertSimpleProduct2OnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertSimpleProduct2OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertSimpleProduct2OnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-simple2-bundle"); // stepKey: seeProductNameAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-simple2-bundle"); // stepKey: seeProductSkuAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "20.00"); // stepKey: seeProductPriceAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "102"); // stepKey: seeProductQuantityAssertSimpleProduct2OnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertSimpleProduct2OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertSimpleProduct2OnEditPageWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", "2"); // stepKey: seeProductWeightAssertSimpleProduct2OnEditPage
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeProductVisibilityAssertSimpleProduct2OnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-bundle')]"); // stepKey: seeProductCategoriesAssertSimpleProduct2OnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct2OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct2ImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertSimpleProduct2ImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSimpleProduct2ImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]", 30); // stepKey: seeImageAssertSimpleProduct2ImageOnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct2ImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='image']"); // stepKey: seeBaseImageRoleSimple2
		$I->comment("Entering Action Group [assertSimpleProduct2SmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertSimpleProduct2SmallImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSimpleProduct2SmallImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]", 30); // stepKey: seeImageAssertSimpleProduct2SmallImageOnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct2SmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='small_image']"); // stepKey: seeSmallImageRoleSimple2
		$I->comment("Entering Action Group [assertSimpleProduct2ThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertSimpleProduct2ThumbnailImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSimpleProduct2ThumbnailImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]", 30); // stepKey: seeImageAssertSimpleProduct2ThumbnailImageOnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct2ThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='thumbnail']"); // stepKey: seeThumbnailImageRoleSimple2
		$I->comment("Admin: Verify Simple Product 3 on Edit Product Page");
		$I->comment("Entering Action Group [goToSimpleProduct3EditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageGoToSimpleProduct3EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadGoToSimpleProduct3EditPage
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersGoToSimpleProduct3EditPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersGoToSimpleProduct3EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersGoToSimpleProduct3EditPage
		$I->dontSeeElement(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: dontSeeClearFiltersGoToSimpleProduct3EditPage
		$I->waitForPageLoad(30); // stepKey: dontSeeClearFiltersGoToSimpleProduct3EditPageWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabGoToSimpleProduct3EditPage
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewGoToSimpleProduct3EditPage
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewGoToSimpleProduct3EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetToDefaultViewGoToSimpleProduct3EditPage
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedGoToSimpleProduct3EditPage
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersGoToSimpleProduct3EditPage
		$I->fillField("input.admin__control-text[name='sku']", "import-product-simple3-bundle"); // stepKey: fillProductSkuFilterGoToSimpleProduct3EditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToSimpleProduct3EditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToSimpleProduct3EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToSimpleProduct3EditPage
		$I->click("//td/div[text()='import-product-simple3-bundle']"); // stepKey: clickProductGoToSimpleProduct3EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToSimpleProduct3EditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToSimpleProduct3EditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-simple3-bundle"); // stepKey: seeProductSKUGoToSimpleProduct3EditPage
		$I->comment("Exiting Action Group [goToSimpleProduct3EditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct3OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertSimpleProduct3OnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertSimpleProduct3OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertSimpleProduct3OnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-simple3-bundle"); // stepKey: seeProductNameAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-simple3-bundle"); // stepKey: seeProductSkuAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "30.00"); // stepKey: seeProductPriceAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "103"); // stepKey: seeProductQuantityAssertSimpleProduct3OnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertSimpleProduct3OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertSimpleProduct3OnEditPageWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", "3"); // stepKey: seeProductWeightAssertSimpleProduct3OnEditPage
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeProductVisibilityAssertSimpleProduct3OnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-bundle')]"); // stepKey: seeProductCategoriesAssertSimpleProduct3OnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct3OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct3ImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertSimpleProduct3ImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSimpleProduct3ImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertSimpleProduct3ImageOnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct3ImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='image']"); // stepKey: seeBaseImageRoleSimple3
		$I->comment("Entering Action Group [assertSimpleProduct3SmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertSimpleProduct3SmallImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSimpleProduct3SmallImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertSimpleProduct3SmallImageOnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct3SmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='small_image']"); // stepKey: seeSmallImageRoleSimple3
		$I->comment("Entering Action Group [assertSimpleProduct3ThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertSimpleProduct3ThumbnailImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertSimpleProduct3ThumbnailImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertSimpleProduct3ThumbnailImageOnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct3ThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='thumbnail']"); // stepKey: seeThumbnailImageRoleSimple3
		$I->comment("Admin: Verify Bundle Product Common Data on Edit Product Page");
		$I->comment("Entering Action Group [goToBundleProductEditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageGoToBundleProductEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadGoToBundleProductEditPage
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersGoToBundleProductEditPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersGoToBundleProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersGoToBundleProductEditPage
		$I->dontSeeElement(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: dontSeeClearFiltersGoToBundleProductEditPage
		$I->waitForPageLoad(30); // stepKey: dontSeeClearFiltersGoToBundleProductEditPageWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabGoToBundleProductEditPage
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewGoToBundleProductEditPage
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewGoToBundleProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetToDefaultViewGoToBundleProductEditPage
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedGoToBundleProductEditPage
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersGoToBundleProductEditPage
		$I->fillField("input.admin__control-text[name='sku']", "import-product-bundle"); // stepKey: fillProductSkuFilterGoToBundleProductEditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToBundleProductEditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToBundleProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToBundleProductEditPage
		$I->click("//td/div[text()='import-product-bundle']"); // stepKey: clickProductGoToBundleProductEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToBundleProductEditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToBundleProductEditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-bundle"); // stepKey: seeProductSKUGoToBundleProductEditPage
		$I->comment("Exiting Action Group [goToBundleProductEditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertBundleProductOnEditPage] AdminAssertBundleProductGeneralInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertBundleProductOnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertBundleProductOnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertBundleProductOnEditPageWaitForPageLoad
		$seeProductAttributeSetAssertBundleProductOnEditPage = $I->executeJS("return document.querySelector(\"div[data-index='attribute_set_id'] .admin__field-control\").innerText"); // stepKey: seeProductAttributeSetAssertBundleProductOnEditPage
		$I->assertEquals("Default", $seeProductAttributeSetAssertBundleProductOnEditPage); // stepKey: assertProductAttributeSetAssertBundleProductOnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-bundle"); // stepKey: seeProductNameAssertBundleProductOnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-bundle"); // stepKey: seeProductSkuAssertBundleProductOnEditPage
		$dynamicSkuCheckedValueAssertBundleProductOnEditPage = $I->executeJS("return document.querySelector(\"[name='product[sku_type]']\").checked.toString()"); // stepKey: dynamicSkuCheckedValueAssertBundleProductOnEditPage
		$I->assertEquals("true", $dynamicSkuCheckedValueAssertBundleProductOnEditPage); // stepKey: assertDynamicSkuAssertBundleProductOnEditPage
		$I->seeInField(".admin__field[data-index=price] input", ""); // stepKey: seeProductPriceAssertBundleProductOnEditPage
		$dynamicPriceCheckedValueAssertBundleProductOnEditPage = $I->executeJS("return document.querySelector(\"[name='product[price_type]']\").checked.toString()"); // stepKey: dynamicPriceCheckedValueAssertBundleProductOnEditPage
		$I->assertEquals("true", $dynamicPriceCheckedValueAssertBundleProductOnEditPage); // stepKey: assertDynamicPriceAssertBundleProductOnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "0"); // stepKey: seeProductQuantityAssertBundleProductOnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertBundleProductOnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertBundleProductOnEditPageWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", ""); // stepKey: seeProductWeightAssertBundleProductOnEditPage
		$dynamicWeightCheckedValueAssertBundleProductOnEditPage = $I->executeJS("return document.querySelector(\"[name='product[weight_type]']\").checked.toString()"); // stepKey: dynamicWeightCheckedValueAssertBundleProductOnEditPage
		$I->assertEquals("true", $dynamicWeightCheckedValueAssertBundleProductOnEditPage); // stepKey: assertDynamicWeightAssertBundleProductOnEditPage
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeProductVisibilityAssertBundleProductOnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-bundle')]"); // stepKey: seeProductCategoriesAssertBundleProductOnEditPage
		$I->comment("Exiting Action Group [assertBundleProductOnEditPage] AdminAssertBundleProductGeneralInfoOnEditPageActionGroup");
		$I->comment("Entering Action Group [assertBundleProductBaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertBundleProductBaseImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertBundleProductBaseImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertBundleProductBaseImageOnEditPage
		$I->comment("Exiting Action Group [assertBundleProductBaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='image']"); // stepKey: seeBaseImageRoleBundle
		$I->comment("Entering Action Group [assertBundleProductSmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertBundleProductSmallImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertBundleProductSmallImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]", 30); // stepKey: seeImageAssertBundleProductSmallImageOnEditPage
		$I->comment("Exiting Action Group [assertBundleProductSmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='small_image']"); // stepKey: seeSmallImageRoleBundle
		$I->comment("Entering Action Group [assertBundleProductThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertBundleProductThumbnailImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertBundleProductThumbnailImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertBundleProductThumbnailImageOnEditPage
		$I->comment("Exiting Action Group [assertBundleProductThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='thumbnail']"); // stepKey: seeThumbnailImageRoleBundle
		$I->comment("Admin: Verify Bundle Product Information on Edit Product Page");
		$I->seeOptionIsSelected(".admin__control-select[name='product[shipment_type]']", "Together"); // stepKey: seeShipBundleItemsTogether
		$I->seeNumberOfElements("[data-index=bundle_options]>tbody>tr", "2"); // stepKey: see2BundleOptionsAdmin
		$I->comment("Entering Action Group [verifyBundleProductOption1] AdminVerifyBundleProductOptionActionGroup");
		$indexMinusOneVerifyBundleProductOption1 = $I->executeJS("return (1-1).toString()"); // stepKey: indexMinusOneVerifyBundleProductOption1
		$I->waitForElementVisible("[name='bundle_options[bundle_options][{$indexMinusOneVerifyBundleProductOption1}][title]']", 30); // stepKey: waitForOptionTitleVerifyBundleProductOption1
		$I->seeInField("[name='bundle_options[bundle_options][{$indexMinusOneVerifyBundleProductOption1}][title]']", "Bundle Option A"); // stepKey: seeOptionTitleVerifyBundleProductOption1
		$I->seeOptionIsSelected("[name='bundle_options[bundle_options][{$indexMinusOneVerifyBundleProductOption1}][type]']", "radio"); // stepKey: seeOptionTypeVerifyBundleProductOption1
		$optionRequiredValueVerifyBundleProductOption1 = $I->executeJS("return document.querySelector(\"[name='bundle_options[bundle_options][{$indexMinusOneVerifyBundleProductOption1}][required]']\").checked.toString()"); // stepKey: optionRequiredValueVerifyBundleProductOption1
		$I->assertEquals("true", $optionRequiredValueVerifyBundleProductOption1); // stepKey: assertOptionRequiredValueVerifyBundleProductOption1
		$I->seeNumberOfElements("[data-index=bundle_options]>tbody>tr:nth-of-type(1) table[data-index=bundle_selections]>tbody>tr", "2"); // stepKey: seeNumberOfProductsInOptionVerifyBundleProductOption1
		$I->comment("Exiting Action Group [verifyBundleProductOption1] AdminVerifyBundleProductOptionActionGroup");
		$I->comment("Entering Action Group [verifyBundleProductOption1Product1] AdminVerifyProductInBundleProductOptionActionGroup");
		$optionIndexMinusOneVerifyBundleProductOption1Product1 = $I->executeJS("return (1-1).toString()"); // stepKey: optionIndexMinusOneVerifyBundleProductOption1Product1
		$productIndexMinusOneVerifyBundleProductOption1Product1 = $I->executeJS("return (1-1).toString()"); // stepKey: productIndexMinusOneVerifyBundleProductOption1Product1
		$I->waitForElementVisible("[name='bundle_options[bundle_options][{$optionIndexMinusOneVerifyBundleProductOption1Product1}][bundle_selections][{$productIndexMinusOneVerifyBundleProductOption1Product1}][is_default]']", 30); // stepKey: waitForIsDefaultVerifyBundleProductOption1Product1
		$isDefaultValueVerifyBundleProductOption1Product1 = $I->executeJS("return document.querySelector(\"[name='bundle_options[bundle_options][{$optionIndexMinusOneVerifyBundleProductOption1Product1}][bundle_selections][{$productIndexMinusOneVerifyBundleProductOption1Product1}][is_default]']\").checked.toString()"); // stepKey: isDefaultValueVerifyBundleProductOption1Product1
		$I->assertEquals("false", $isDefaultValueVerifyBundleProductOption1Product1); // stepKey: assertIsDefaultValueVerifyBundleProductOption1Product1
		$I->see("import-product-simple1-bundle", "[data-index=bundle_options]>tbody>tr:nth-of-type(1) table[data-index=bundle_selections]>tbody>tr:nth-of-type(1) div[data-index=name]"); // stepKey: seeNameVerifyBundleProductOption1Product1
		$I->see("import-product-simple1-bundle", "[data-index=bundle_options]>tbody>tr:nth-of-type(1) table[data-index=bundle_selections]>tbody>tr:nth-of-type(1) div[data-index=sku]"); // stepKey: seeSkuVerifyBundleProductOption1Product1
		$I->seeInField("[name='bundle_options[bundle_options][{$optionIndexMinusOneVerifyBundleProductOption1Product1}][bundle_selections][{$productIndexMinusOneVerifyBundleProductOption1Product1}][selection_qty]']", "2"); // stepKey: seeDefaultQuantityVerifyBundleProductOption1Product1
		$userDefinedValueVerifyBundleProductOption1Product1 = $I->executeJS("return document.querySelector(\"[name='bundle_options[bundle_options][{$optionIndexMinusOneVerifyBundleProductOption1Product1}][bundle_selections][{$productIndexMinusOneVerifyBundleProductOption1Product1}][selection_can_change_qty]']\").checked.toString()"); // stepKey: userDefinedValueVerifyBundleProductOption1Product1
		$I->assertEquals("true", $userDefinedValueVerifyBundleProductOption1Product1); // stepKey: assertUserDefinedValueValueVerifyBundleProductOption1Product1
		$I->comment("Exiting Action Group [verifyBundleProductOption1Product1] AdminVerifyProductInBundleProductOptionActionGroup");
		$I->comment("Entering Action Group [verifyBundleProductOption1Product2] AdminVerifyProductInBundleProductOptionActionGroup");
		$optionIndexMinusOneVerifyBundleProductOption1Product2 = $I->executeJS("return (1-1).toString()"); // stepKey: optionIndexMinusOneVerifyBundleProductOption1Product2
		$productIndexMinusOneVerifyBundleProductOption1Product2 = $I->executeJS("return (2-1).toString()"); // stepKey: productIndexMinusOneVerifyBundleProductOption1Product2
		$I->waitForElementVisible("[name='bundle_options[bundle_options][{$optionIndexMinusOneVerifyBundleProductOption1Product2}][bundle_selections][{$productIndexMinusOneVerifyBundleProductOption1Product2}][is_default]']", 30); // stepKey: waitForIsDefaultVerifyBundleProductOption1Product2
		$isDefaultValueVerifyBundleProductOption1Product2 = $I->executeJS("return document.querySelector(\"[name='bundle_options[bundle_options][{$optionIndexMinusOneVerifyBundleProductOption1Product2}][bundle_selections][{$productIndexMinusOneVerifyBundleProductOption1Product2}][is_default]']\").checked.toString()"); // stepKey: isDefaultValueVerifyBundleProductOption1Product2
		$I->assertEquals("true", $isDefaultValueVerifyBundleProductOption1Product2); // stepKey: assertIsDefaultValueVerifyBundleProductOption1Product2
		$I->see("import-product-simple2-bundle", "[data-index=bundle_options]>tbody>tr:nth-of-type(1) table[data-index=bundle_selections]>tbody>tr:nth-of-type(2) div[data-index=name]"); // stepKey: seeNameVerifyBundleProductOption1Product2
		$I->see("import-product-simple2-bundle", "[data-index=bundle_options]>tbody>tr:nth-of-type(1) table[data-index=bundle_selections]>tbody>tr:nth-of-type(2) div[data-index=sku]"); // stepKey: seeSkuVerifyBundleProductOption1Product2
		$I->seeInField("[name='bundle_options[bundle_options][{$optionIndexMinusOneVerifyBundleProductOption1Product2}][bundle_selections][{$productIndexMinusOneVerifyBundleProductOption1Product2}][selection_qty]']", "4"); // stepKey: seeDefaultQuantityVerifyBundleProductOption1Product2
		$userDefinedValueVerifyBundleProductOption1Product2 = $I->executeJS("return document.querySelector(\"[name='bundle_options[bundle_options][{$optionIndexMinusOneVerifyBundleProductOption1Product2}][bundle_selections][{$productIndexMinusOneVerifyBundleProductOption1Product2}][selection_can_change_qty]']\").checked.toString()"); // stepKey: userDefinedValueVerifyBundleProductOption1Product2
		$I->assertEquals("false", $userDefinedValueVerifyBundleProductOption1Product2); // stepKey: assertUserDefinedValueValueVerifyBundleProductOption1Product2
		$I->comment("Exiting Action Group [verifyBundleProductOption1Product2] AdminVerifyProductInBundleProductOptionActionGroup");
		$I->comment("Entering Action Group [verifyBundleProductOption2] AdminVerifyBundleProductOptionActionGroup");
		$indexMinusOneVerifyBundleProductOption2 = $I->executeJS("return (2-1).toString()"); // stepKey: indexMinusOneVerifyBundleProductOption2
		$I->waitForElementVisible("[name='bundle_options[bundle_options][{$indexMinusOneVerifyBundleProductOption2}][title]']", 30); // stepKey: waitForOptionTitleVerifyBundleProductOption2
		$I->seeInField("[name='bundle_options[bundle_options][{$indexMinusOneVerifyBundleProductOption2}][title]']", "Bundle Option B"); // stepKey: seeOptionTitleVerifyBundleProductOption2
		$I->seeOptionIsSelected("[name='bundle_options[bundle_options][{$indexMinusOneVerifyBundleProductOption2}][type]']", "checkbox"); // stepKey: seeOptionTypeVerifyBundleProductOption2
		$optionRequiredValueVerifyBundleProductOption2 = $I->executeJS("return document.querySelector(\"[name='bundle_options[bundle_options][{$indexMinusOneVerifyBundleProductOption2}][required]']\").checked.toString()"); // stepKey: optionRequiredValueVerifyBundleProductOption2
		$I->assertEquals("false", $optionRequiredValueVerifyBundleProductOption2); // stepKey: assertOptionRequiredValueVerifyBundleProductOption2
		$I->seeNumberOfElements("[data-index=bundle_options]>tbody>tr:nth-of-type(2) table[data-index=bundle_selections]>tbody>tr", "1"); // stepKey: seeNumberOfProductsInOptionVerifyBundleProductOption2
		$I->comment("Exiting Action Group [verifyBundleProductOption2] AdminVerifyBundleProductOptionActionGroup");
		$I->comment("Entering Action Group [verifyBundleProductOption2Product1] AdminVerifyProductInBundleProductOptionActionGroup");
		$optionIndexMinusOneVerifyBundleProductOption2Product1 = $I->executeJS("return (2-1).toString()"); // stepKey: optionIndexMinusOneVerifyBundleProductOption2Product1
		$productIndexMinusOneVerifyBundleProductOption2Product1 = $I->executeJS("return (1-1).toString()"); // stepKey: productIndexMinusOneVerifyBundleProductOption2Product1
		$I->waitForElementVisible("[name='bundle_options[bundle_options][{$optionIndexMinusOneVerifyBundleProductOption2Product1}][bundle_selections][{$productIndexMinusOneVerifyBundleProductOption2Product1}][is_default]']", 30); // stepKey: waitForIsDefaultVerifyBundleProductOption2Product1
		$isDefaultValueVerifyBundleProductOption2Product1 = $I->executeJS("return document.querySelector(\"[name='bundle_options[bundle_options][{$optionIndexMinusOneVerifyBundleProductOption2Product1}][bundle_selections][{$productIndexMinusOneVerifyBundleProductOption2Product1}][is_default]']\").checked.toString()"); // stepKey: isDefaultValueVerifyBundleProductOption2Product1
		$I->assertEquals("false", $isDefaultValueVerifyBundleProductOption2Product1); // stepKey: assertIsDefaultValueVerifyBundleProductOption2Product1
		$I->see("import-product-simple3-bundle", "[data-index=bundle_options]>tbody>tr:nth-of-type(2) table[data-index=bundle_selections]>tbody>tr:nth-of-type(1) div[data-index=name]"); // stepKey: seeNameVerifyBundleProductOption2Product1
		$I->see("import-product-simple3-bundle", "[data-index=bundle_options]>tbody>tr:nth-of-type(2) table[data-index=bundle_selections]>tbody>tr:nth-of-type(1) div[data-index=sku]"); // stepKey: seeSkuVerifyBundleProductOption2Product1
		$I->seeInField("[name='bundle_options[bundle_options][{$optionIndexMinusOneVerifyBundleProductOption2Product1}][bundle_selections][{$productIndexMinusOneVerifyBundleProductOption2Product1}][selection_qty]']", "3"); // stepKey: seeDefaultQuantityVerifyBundleProductOption2Product1
		$userDefinedValueVerifyBundleProductOption2Product1 = $I->executeJS("return document.querySelector(\"[name='bundle_options[bundle_options][{$optionIndexMinusOneVerifyBundleProductOption2Product1}][bundle_selections][{$productIndexMinusOneVerifyBundleProductOption2Product1}][selection_can_change_qty]']\").checked.toString()"); // stepKey: userDefinedValueVerifyBundleProductOption2Product1
		$I->assertEquals("false", $userDefinedValueVerifyBundleProductOption2Product1); // stepKey: assertUserDefinedValueValueVerifyBundleProductOption2Product1
		$I->comment("Exiting Action Group [verifyBundleProductOption2Product1] AdminVerifyProductInBundleProductOptionActionGroup");
		$I->comment("Storefront: Verify Bundle Product In Category");
		$I->comment("Entering Action Group [loginStorefront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginStorefront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginStorefront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginStorefront
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginStorefront
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginStorefront
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginStorefront
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginStorefrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginStorefront
		$I->comment("Exiting Action Group [loginStorefront] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [goToCategoryPage] StorefrontNavigateToCategoryUrlActionGroup");
		$I->amOnPage("/import-category-bundle.html"); // stepKey: goToStorefrontCategoryPageGoToCategoryPage
		$I->comment("Exiting Action Group [goToCategoryPage] StorefrontNavigateToCategoryUrlActionGroup");
		$I->seeNumberOfElements(".product-item-name", "4"); // stepKey: see4Products
		$I->see("import-product-simple1-bundle", "#maincontent .column.main"); // stepKey: seeSimpleProduct1
		$I->see("import-product-simple2-bundle", "#maincontent .column.main"); // stepKey: seeSimpleProduct2
		$I->see("import-product-simple3-bundle", "#maincontent .column.main"); // stepKey: seeSimpleProduct3
		$I->see("import-product-bundle", "#maincontent .column.main"); // stepKey: seeBundleProduct
		$I->comment("Storefront: Verify Bundle Product Info & Images");
		$I->comment("Entering Action Group [openProductStorefrontPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/import-product-bundle.html"); // stepKey: openProductPageOpenProductStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductStorefrontPage
		$I->comment("Exiting Action Group [openProductStorefrontPage] StorefrontOpenProductPageActionGroup");
		$I->see("import-product-bundle", ".base"); // stepKey: seeProductName
		$I->see("import-product-bundle", ".product.attribute.sku>.value"); // stepKey: seeSku
		$I->see("From $20.00 To $170.00", "div.price-box.price-final_price"); // stepKey: seePrice
		$I->seeElement("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'magento-logo')]"); // stepKey: seeProduct1BaseImage
		$I->seeElement("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'm-logo')]"); // stepKey: seeProduct2BaseImage
		$I->seeElement("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'adobe-base')]"); // stepKey: seeProduct3BaseImage
		$I->comment("Storefront: Verify Default Customization Summary");
		$I->comment("Entering Action Group [clickCustomizeAndAddToCartButton] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCartButton
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCartButtonWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCartButton
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCartButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickCustomizeAndAddToCartButton
		$I->comment("Exiting Action Group [clickCustomizeAndAddToCartButton] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->see("$80.00", "//*[@class='bundle-info']//*[contains(@id,'product-price')]/span"); // stepKey: seeCustomizationPrice
		$I->see("Bundle Option A: 4 x import-product-simple2-bundle", "#bundle-summary"); // stepKey: seeCustomizationSummary
		$I->comment("Storefront: Verify Default Bundle Option 1");
		$I->seeNumberOfElements("#product-options-wrapper div.field.option", "2"); // stepKey: see2TotalBundleOptions
		$I->see("Bundle Option A", "#product-options-wrapper div.field.option:nth-of-type(1)"); // stepKey: seeOption1Title
		$I->seeElement("#product-options-wrapper div.field.option:nth-of-type(1).required"); // stepKey: seeOption1Required
		$I->seeNumberOfElements("#product-options-wrapper div.field.option:nth-of-type(1) .choice", "2"); // stepKey: see2TotalProductsInBundleOption1
		$I->dontSeeCheckboxIsChecked("#product-options-wrapper div.field.option:nth-of-type(1) .choice:nth-of-type(1) input"); // stepKey: dontSeeOption1Product1Checked
		$I->see("import-product-simple1-bundle", "#product-options-wrapper div.field.option:nth-of-type(1) .choice:nth-of-type(1) .product-name"); // stepKey: seeOption1Product1Name
		$I->see("+ $10.00", "#product-options-wrapper div.field.option:nth-of-type(1) .choice:nth-of-type(1) .price-notice"); // stepKey: seeOption1Product1Price
		$I->seeCheckboxIsChecked("#product-options-wrapper div.field.option:nth-of-type(1) .choice:nth-of-type(2) input"); // stepKey: seeOption1Product2Checked
		$I->see("import-product-simple2-bundle", "#product-options-wrapper div.field.option:nth-of-type(1) .choice:nth-of-type(2) .product-name"); // stepKey: seeOption1Product2Name
		$I->see("+ $20.00", "#product-options-wrapper div.field.option:nth-of-type(1) .choice:nth-of-type(2) .price-notice"); // stepKey: seeOption1Product2Price
		$I->seeInField("#product-options-wrapper div.field.option:nth-of-type(1) .qty input", "4"); // stepKey: seeOption1DefaultQuantity
		$I->seeElement("#product-options-wrapper div.field.option:nth-of-type(1) .qty input[disabled]"); // stepKey: seeOption1QuantityDisabled
		$I->comment("Storefront: Verify Default Bundle Option 2");
		$I->see("Bundle Option B", "#product-options-wrapper div.field.option:nth-of-type(2)"); // stepKey: seeOption2Title
		$I->dontSeeElement("#product-options-wrapper div.field.option:nth-of-type(2).required"); // stepKey: seeOption2NotRequired
		$I->seeNumberOfElements("#product-options-wrapper div.field.option:nth-of-type(1) .choice", "2"); // stepKey: see1TotalProductsInBundleOption2
		$I->dontSeeCheckboxIsChecked("#product-options-wrapper div.field.option:nth-of-type(2) .choice:nth-of-type(1) input"); // stepKey: dontSeeOption2Product1Checked
		$I->see("3 x import-product-simple3-bundle", "#product-options-wrapper div.field.option:nth-of-type(2) .choice:nth-of-type(1) .product-name"); // stepKey: seeOption2Product1Name
		$I->see("+ $30.00", "#product-options-wrapper div.field.option:nth-of-type(2) .choice:nth-of-type(1) .price-notice"); // stepKey: seeOption2Product1Price
		$I->dontSeeElement("#product-options-wrapper div.field.option:nth-of-type(2) .qty input"); // stepKey: dontSeeOption2QuantityInput
		$I->comment("Storefront: Select Product 1 in Option 1 & Select Option 2");
		$I->checkOption("#product-options-wrapper div.field.option:nth-of-type(1) .choice:nth-of-type(1) input"); // stepKey: checkProduct1InOption1
		$I->seeInField("#product-options-wrapper div.field.option:nth-of-type(1) .qty input", "2"); // stepKey: seeOption1UpdatedQuantity
		$I->dontSeeElement("#product-options-wrapper div.field.option:nth-of-type(1) .qty input[disabled]"); // stepKey: seeOption1QuantityEnabled
		$I->checkOption("#product-options-wrapper div.field.option:nth-of-type(2) .choice:nth-of-type(1) input"); // stepKey: checkOption2
		$I->comment("Storefront: Verify Updated Customization Summary");
		$I->see("$110.00", "//*[@class='bundle-info']//*[contains(@id,'product-price')]/span"); // stepKey: seeCustomizationPrice2
		$I->see("Bundle Option A: 2 x import-product-simple1-bundle", "#bundle-summary"); // stepKey: seeUpdatedCustomizationSummary
		$I->see("Bundle Option B: 3 x import-product-simple3-bundle", "#bundle-summary"); // stepKey: seeUpdatedCustomizationSummary2
		$I->comment("Purchase Bundle Product");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddToTheCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->scrollTo("#product-addtocart-button"); // stepKey: scrollToAddToCartButtonAddProductToCart
		$I->waitForPageLoad(60); // stepKey: scrollToAddToCartButtonAddProductToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddToTheCartActionGroup");
		$I->comment("Entering Action Group [navigateToCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->amOnPage("/checkout"); // stepKey: openCheckoutPageNavigateToCheckoutPage
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadedNavigateToCheckoutPage
		$I->comment("Exiting Action Group [navigateToCheckoutPage] StorefrontOpenCheckoutPageActionGroup");
		$I->comment("Entering Action Group [selectFlatRateShippingMethod] StorefrontSetShippingMethodActionGroup");
		$I->checkOption("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input"); // stepKey: selectFlatRateShippingMethodSelectFlatRateShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRateShippingMethod
		$I->comment("Exiting Action Group [selectFlatRateShippingMethod] StorefrontSetShippingMethodActionGroup");
		$I->comment("Entering Action Group [clickNextOnShippingStep] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNextOnShippingStep
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextOnShippingStepWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonClickNextOnShippingStep
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonClickNextOnShippingStepWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNextOnShippingStep
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextOnShippingStepWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearClickNextOnShippingStep
		$I->comment("Exiting Action Group [clickNextOnShippingStep] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Entering Action Group [selectCheckMoneyOrder] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyOrder
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyOrder
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyOrder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyOrder
		$I->comment("Exiting Action Group [selectCheckMoneyOrder] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [clickPlacePurchaseOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickPlacePurchaseOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickPlacePurchaseOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickPlacePurchaseOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickPlacePurchaseOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickPlacePurchaseOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickPlacePurchaseOrder
		$I->comment("Exiting Action Group [clickPlacePurchaseOrder] ClickPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Confirm Purchased Bundle Product");
		$I->comment("Entering Action Group [openOrderFromSuccessPage] StorefrontOpenOrderFromSuccessPageActionGroup");
		$I->click("//div[contains(@class,'success')]//a[contains(.,'{$grabOrderNumber}')]"); // stepKey: clickOrderNumberLinkOpenOrderFromSuccessPage
		$I->waitForPageLoad(30); // stepKey: clickOrderNumberLinkOpenOrderFromSuccessPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageIsLoadedOpenOrderFromSuccessPage
		$I->see("Order # {$grabOrderNumber}", ".page-title span"); // stepKey: assertOrderNumberIsCorrectOpenOrderFromSuccessPage
		$I->comment("Exiting Action Group [openOrderFromSuccessPage] StorefrontOpenOrderFromSuccessPageActionGroup");
		$I->comment("Entering Action Group [verifyProductRow1InOrder] StorefrontVerifyCustomerOrderProductRowDataActionGroup");
		$I->waitForText("import-product-bundle", 30, "#my-orders-table tbody:nth-of-type(1) td.name"); // stepKey: seeProductNameVerifyProductRow1InOrder
		$I->waitForText("import-product-bundle-import-product-simple1- bundle-import-product-simple3-bundle", 30, "#my-orders-table tbody:nth-of-type(1) td.sku"); // stepKey: seeProductSkuVerifyProductRow1InOrder
		$I->waitForText("$110.00", 30, "#my-orders-table tbody:nth-of-type(1) td.price"); // stepKey: seeProductPriceVerifyProductRow1InOrder
		$I->waitForText("1", 30, "#my-orders-table tbody:nth-of-type(1) td.qty"); // stepKey: seeProductQuantityVerifyProductRow1InOrder
		$I->waitForText("$110.00", 30, "#my-orders-table tbody:nth-of-type(1) td.subtotal"); // stepKey: seeProductSubtotalVerifyProductRow1InOrder
		$I->comment("Exiting Action Group [verifyProductRow1InOrder] StorefrontVerifyCustomerOrderProductRowDataActionGroup");
		$I->seeNumberOfElements("#my-orders-table tbody:nth-of-type(1) .options-label", "2"); // stepKey: see2ProductOptions
		$I->seeNumberOfElements("#my-orders-table tbody:nth-of-type(1) .item-options-container", "2"); // stepKey: see2ProductOptionProducts
		$I->comment("Entering Action Group [verifyOrderedOption1] StorefrontVerifyBundleProductOptionOnOrderActionGroup");
		$I->waitForText("Bundle Option A", 30, "//table[@id='my-orders-table']//tbody[1]//tr[@class='options-label'][1]"); // stepKey: seeOptionTitleVerifyOrderedOption1
		$I->see("2 x import-product-simple1-bundle $10.00", "//table[@id='my-orders-table']//tbody[1]//tr[contains(@class,'item-options-container')][1]//td[@data-th='Product Name']"); // stepKey: seeOptionProductNameVerifyOrderedOption1
		$I->see("import-product-simple1-bundle", "//table[@id='my-orders-table']//tbody[1]//tr[contains(@class,'item-options-container')][1]//td[@data-th='SKU']"); // stepKey: seeOptionProductSkuVerifyOrderedOption1
		$I->see("Ordered 2", "//table[@id='my-orders-table']//tbody[1]//tr[contains(@class,'item-options-container')][1]//td[@data-th='Quantity']"); // stepKey: seeOptionProductQuantityVerifyOrderedOption1
		$I->comment("Exiting Action Group [verifyOrderedOption1] StorefrontVerifyBundleProductOptionOnOrderActionGroup");
		$I->comment("Entering Action Group [verifyOrderedOption2] StorefrontVerifyBundleProductOptionOnOrderActionGroup");
		$I->waitForText("Bundle Option B", 30, "//table[@id='my-orders-table']//tbody[1]//tr[@class='options-label'][2]"); // stepKey: seeOptionTitleVerifyOrderedOption2
		$I->see("3 x import-product-simple3-bundle $30.00", "//table[@id='my-orders-table']//tbody[1]//tr[contains(@class,'item-options-container')][2]//td[@data-th='Product Name']"); // stepKey: seeOptionProductNameVerifyOrderedOption2
		$I->see("import-product-simple3-bundle", "//table[@id='my-orders-table']//tbody[1]//tr[contains(@class,'item-options-container')][2]//td[@data-th='SKU']"); // stepKey: seeOptionProductSkuVerifyOrderedOption2
		$I->see("Ordered 3", "//table[@id='my-orders-table']//tbody[1]//tr[contains(@class,'item-options-container')][2]//td[@data-th='Quantity']"); // stepKey: seeOptionProductQuantityVerifyOrderedOption2
		$I->comment("Exiting Action Group [verifyOrderedOption2] StorefrontVerifyBundleProductOptionOnOrderActionGroup");
	}
}
