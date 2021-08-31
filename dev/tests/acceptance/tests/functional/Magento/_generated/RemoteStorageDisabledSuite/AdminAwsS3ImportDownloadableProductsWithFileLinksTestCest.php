<?php
namespace Magento\AcceptanceTest\_RemoteStorageDisabledSuite\Backend;

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
 * @Title("[NO TESTCASEID]: S3 - Import Downloadable Products with File Links")
 * @Description("Imports a .csv file containing a downloadable product with file links. Verifies that             products are imported successfully.<h3>Test files</h3>app/code/Magento/AwsS3/Test/Mftf/Test/AdminAwsS3ImportDownloadableProductsWithFileLinksTest.xml<br>")
 * @group importExport
 * @group Downloadable
 * @group remote_storage_aws_s3
 * @group remote_storage_disabled
 */
class AdminAwsS3ImportDownloadableProductsWithFileLinksTestCest
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
        $this->helperContainer->create("Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create Category & Customer");
		$I->createEntity("createImportCategory", "hook", "ImportCategory_Downloadable_FileLinks", [], []); // stepKey: createImportCategory
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment('[createDirectoryForImportFiles] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::createDirectory()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->createDirectory("pub/media/import/import-product-downloadable-file-links", 511); // stepKey: createDirectoryForImportFiles
		$I->comment('[copyImportFile] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/import_downloadable_product_file_links.csv", "pub/media/import/import-product-downloadable-file-links/import_downloadable_product_file_links.csv"); // stepKey: copyImportFile
		$I->comment("Copy Images to Import Directory for Product Images");
		$I->comment('[copyBaseImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/magento-logo.png", "pub/media/import/import-product-downloadable-file-links/magento-logo.png"); // stepKey: copyBaseImage
		$I->comment('[copySmallImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/m-logo.gif", "pub/media/import/import-product-downloadable-file-links/m-logo.gif"); // stepKey: copySmallImage
		$I->comment('[copyThumbnailImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/adobe-base.jpg", "pub/media/import/import-product-downloadable-file-links/adobe-base.jpg"); // stepKey: copyThumbnailImage
		$enableRemoteStorage = $I->magentoCLI("setup:config:set --remote-storage-driver=" . getenv("REMOTE_STORAGE_AWSS3_DRIVER") . " --remote-storage-bucket=" . getenv("REMOTE_STORAGE_AWSS3_BUCKET") . " --remote-storage-region=" . getenv("REMOTE_STORAGE_AWSS3_REGION") . " --remote-storage-prefix=" . getenv("REMOTE_STORAGE_AWSS3_PREFIX") . " --remote-storage-key=" . getenv("REMOTE_STORAGE_AWSS3_ACCESS_KEY") . " --remote-storage-secret=" . getenv("REMOTE_STORAGE_AWSS3_SECRET_KEY") . " -n", 60); // stepKey: enableRemoteStorage
		$I->comment($enableRemoteStorage);
		$syncRemoteStorage = $I->magentoCLI("remote-storage:sync", 120); // stepKey: syncRemoteStorage
		$I->comment($syncRemoteStorage);
		$I->comment('[createDirectoryForImportFilesInS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::createDirectory()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->createDirectory("var/import/images/import-product-downloadable-file-links", 511); // stepKey: createDirectoryForImportFilesInS3
		$I->comment('[copyBaseImageInS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::copy()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->copy("media/import/import-product-downloadable-file-links/magento-logo.png", "var/import/images/import-product-downloadable-file-links/magento-logo.png"); // stepKey: copyBaseImageInS3
		$I->comment('[copySmallImageInS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::copy()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->copy("media/import/import-product-downloadable-file-links/m-logo.gif", "var/import/images/import-product-downloadable-file-links/m-logo.gif"); // stepKey: copySmallImageInS3
		$I->comment('[copyThumbnailImageInS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::copy()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->copy("media/import/import-product-downloadable-file-links/adobe-base.jpg", "var/import/images/import-product-downloadable-file-links/adobe-base.jpg"); // stepKey: copyThumbnailImageInS3
		$I->comment("Copy Images to Import Directory for Downloadable Links");
		$I->comment('[createDirectoryForImportDownloadableLinkFiles] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::createDirectory()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->createDirectory("pub/media/import/import-product-downloadable-file-links", 511); // stepKey: createDirectoryForImportDownloadableLinkFiles
		$I->comment('[copyBaseImage2] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/magento-logo.png", "pub/media/import/import-product-downloadable-file-links/magento-logo.png"); // stepKey: copyBaseImage2
		$I->comment('[copySmallImage2] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/m-logo.gif", "pub/media/import/import-product-downloadable-file-links/m-logo.gif"); // stepKey: copySmallImage2
		$I->comment('[copyThumbnailImage3] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/adobe-base.jpg", "pub/media/import/import-product-downloadable-file-links/adobe-base.jpg"); // stepKey: copyThumbnailImage3
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
		$I->comment("Locally Copy Import Files to Unique Media Import Directory");
		$I->comment("Enable AWS S3 Remote Storage & Sync");
		$I->comment("Copy to Import Directory in AWS S3");
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
		$I->comment('[deleteImportFilesDirectoryS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::deleteDirectory()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->deleteDirectory("media/import/import-product-downloadable-file-links"); // stepKey: deleteImportFilesDirectoryS3
		$I->comment('[deleteImportImagesFilesDirectoryS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::deleteDirectory()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->deleteDirectory("var/import/images/import-product-downloadable-file-links"); // stepKey: deleteImportImagesFilesDirectoryS3
		$I->comment('[deleteDownloadableLinkFilesDirectory] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::deleteDirectory()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->deleteDirectory("pub/media/import/import-product-downloadable-file-links"); // stepKey: deleteDownloadableLinkFilesDirectory
		$I->deleteEntityByUrl("/V1/products/import-product-downloadable-file-links"); // stepKey: deleteImportedDownloadableProduct
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
		$disableRemoteStorage = $I->magentoCLI("setup:config:set --remote-storage-driver=file -n", 60); // stepKey: disableRemoteStorage
		$I->comment($disableRemoteStorage);
		$I->comment('[deleteImportFilesDirectoryLocal] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::deleteDirectory()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->deleteDirectory("pub/media/import/import-product-downloadable-file-links"); // stepKey: deleteImportFilesDirectoryLocal
		$I->comment("Delete S3 Data");
		$I->comment("Disable AWS S3 Remote Storage & Delete Local Data");
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
	 * @Features({"AwsS3"})
	 * @Stories({"Import Products"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAwsS3ImportDownloadableProductsWithFileLinksTest(AcceptanceTester $I)
	{
		$I->comment("Import Downloadable Product & Assert No Errors");
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
		$I->attachFile("#import_file", "import_downloadable_product_file_links.csv"); // stepKey: attachFileForImportFillImportForm
		$I->fillField("#import_images_file_dir", "import-product-downloadable-file-links"); // stepKey: fillImagesFileDirectoryFieldFillImportForm
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
		$I->see("Created: 1, Updated: 0, Deleted: 0", "#import_validation_messages .message-notice"); // stepKey: seeNoticeMessage
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
		$I->see("import_downloadable_product_file_links.csv", "table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: seeImportedFile
		$I->waitForPageLoad(60); // stepKey: seeImportedFileWaitForPageLoad
		$I->see("Created: 1, Updated: 0, Deleted: 0", "table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: seeSummary
		$I->waitForPageLoad(60); // stepKey: seeSummaryWaitForPageLoad
		$I->comment("Admin: Verify Downloadable Product on Edit Product Page");
		$I->comment("Entering Action Group [goToDownloadableProductEditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageGoToDownloadableProductEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadGoToDownloadableProductEditPage
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersGoToDownloadableProductEditPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersGoToDownloadableProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersGoToDownloadableProductEditPage
		$I->dontSeeElement(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: dontSeeClearFiltersGoToDownloadableProductEditPage
		$I->waitForPageLoad(30); // stepKey: dontSeeClearFiltersGoToDownloadableProductEditPageWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabGoToDownloadableProductEditPage
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewGoToDownloadableProductEditPage
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewGoToDownloadableProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetToDefaultViewGoToDownloadableProductEditPage
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedGoToDownloadableProductEditPage
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersGoToDownloadableProductEditPage
		$I->fillField("input.admin__control-text[name='sku']", "import-product-downloadable-file-links"); // stepKey: fillProductSkuFilterGoToDownloadableProductEditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToDownloadableProductEditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToDownloadableProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToDownloadableProductEditPage
		$I->click("//td/div[text()='import-product-downloadable-file-links']"); // stepKey: clickProductGoToDownloadableProductEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToDownloadableProductEditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToDownloadableProductEditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-downloadable-file-links"); // stepKey: seeProductSKUGoToDownloadableProductEditPage
		$I->comment("Exiting Action Group [goToDownloadableProductEditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertDownloadableProductOnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertDownloadableProductOnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertDownloadableProductOnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertDownloadableProductOnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetAssertDownloadableProductOnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-downloadable-file-links"); // stepKey: seeProductNameAssertDownloadableProductOnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-downloadable-file-links"); // stepKey: seeProductSkuAssertDownloadableProductOnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "100.00"); // stepKey: seeProductPriceAssertDownloadableProductOnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "100"); // stepKey: seeProductQuantityAssertDownloadableProductOnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertDownloadableProductOnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertDownloadableProductOnEditPageWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", ""); // stepKey: seeProductWeightAssertDownloadableProductOnEditPage
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeProductVisibilityAssertDownloadableProductOnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-downloadable-file-links')]"); // stepKey: seeProductCategoriesAssertDownloadableProductOnEditPage
		$I->comment("Exiting Action Group [assertDownloadableProductOnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->comment("Entering Action Group [assertProductBaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProductBaseImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductBaseImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertProductBaseImageOnEditPage
		$I->comment("Exiting Action Group [assertProductBaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='image']"); // stepKey: seeBaseImageRole
		$I->comment("Entering Action Group [assertProductSmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProductSmallImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductSmallImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]", 30); // stepKey: seeImageAssertProductSmallImageOnEditPage
		$I->comment("Exiting Action Group [assertProductSmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='small_image']"); // stepKey: seeSmallImageRole
		$I->comment("Entering Action Group [assertProductThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProductThumbnailImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProductThumbnailImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertProductThumbnailImageOnEditPage
		$I->comment("Exiting Action Group [assertProductThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='thumbnail']"); // stepKey: seeThumbnailImageRole
		$I->comment("Admin: Verify Downloadable Information");
		$I->comment("Entering Action Group [expandDownloadableSection] ExpandAdminProductSectionActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageExpandDownloadableSection
		$I->waitForElementVisible("div[data-index='downloadable']", 30); // stepKey: waitForSectionExpandDownloadableSection
		$I->waitForPageLoad(30); // stepKey: waitForSectionExpandDownloadableSectionWaitForPageLoad
		$I->conditionalClick("div[data-index='downloadable']", "//div[@data-index='link']", false); // stepKey: expandSectionExpandDownloadableSection
		$I->waitForPageLoad(30); // stepKey: expandSectionExpandDownloadableSectionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSectionToExpandExpandDownloadableSection
		$I->comment("Exiting Action Group [expandDownloadableSection] ExpandAdminProductSectionActionGroup");
		$I->seeCheckboxIsChecked("input[name='is_downloadable']"); // stepKey: seeDownloadableProductChecked
		$I->seeInField("input[name='product[links_title]']", "Links"); // stepKey: seeLinksTitle
		$I->seeCheckboxIsChecked("input[name='product[links_purchased_separately]']"); // stepKey: seeLinksPurchasedSeparateChecked
		$I->comment("Entering Action Group [verifyDownloadableLinkAdmin] AdminAssertDownloadableLinkInformationActionGroup");
		$I->conditionalClick("div[data-index='downloadable']", "input[name='downloadable[sample][0][title]']", false); // stepKey: expandDownloadableSectionVerifyDownloadableLinkAdmin
		$I->waitForElementVisible("input[name='downloadable[sample][0][title]']", 30); // stepKey: waitForDownloadableLinksVerifyDownloadableLinkAdmin
		$I->seeInField("input[name='downloadable[link][0][title]']", "Link1"); // stepKey: seeTitleVerifyDownloadableLinkAdmin
		$I->seeInField("input[name='downloadable[link][0][price]']", "3.00"); // stepKey: seePriceVerifyDownloadableLinkAdmin
		$I->seeInField("select[name='downloadable[link][0][type]']", "Upload File"); // stepKey: seeFileTypeVerifyDownloadableLinkAdmin
		$grabFileNameOrUrlVerifyDownloadableLinkAdmin = $I->executeJS("                     var element = document.evaluate(\"//div[@data-index='container_links']//tr[@data-repeat-index='0']//fieldset[@data-index='container_file']//div[@class='file-uploader-filename']//a|//input[@name='downloadable[link][0][link_url]']\", document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null);                     if ( typeof element.singleNodeValue.value !== \"undefined\" ) {                         return element.singleNodeValue.value; }                     else {                         return element.singleNodeValue.innerText; };"); // stepKey: grabFileNameOrUrlVerifyDownloadableLinkAdmin
		$I->assertStringContainsString("m-logo", $grabFileNameOrUrlVerifyDownloadableLinkAdmin); // stepKey: assertFileNameOrUrlVerifyDownloadableLinkAdmin
		$I->seeInField("select[name='downloadable[link][0][sample][type]']", "Upload File"); // stepKey: seeSampleTypeVerifyDownloadableLinkAdmin
		$grabSampleFileNameOrUrlVerifyDownloadableLinkAdmin = $I->executeJS("                     var element = document.evaluate(\"//div[@data-index='container_links']//tr[@data-repeat-index='0']//fieldset[@data-index='container_sample']//div[@class='file-uploader-filename']//a|//input[@name='downloadable[link][0][sample][url]']\", document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null);                     if ( typeof element.singleNodeValue.value !== \"undefined\" ) {                         return element.singleNodeValue.value; }                     else {                         return element.singleNodeValue.innerText; };"); // stepKey: grabSampleFileNameOrUrlVerifyDownloadableLinkAdmin
		$I->assertStringContainsString("magento-logo", $grabSampleFileNameOrUrlVerifyDownloadableLinkAdmin); // stepKey: assertSampleFileNameOrUrlVerifyDownloadableLinkAdmin
		$I->seeInField("select[name='downloadable[link][0][is_shareable]']", "No"); // stepKey: seeShareableVerifyDownloadableLinkAdmin
		$I->seeInField("input[name='downloadable[link][0][number_of_downloads]']", "0"); // stepKey: seeMaxDownloadsVerifyDownloadableLinkAdmin
		$I->comment("Exiting Action Group [verifyDownloadableLinkAdmin] AdminAssertDownloadableLinkInformationActionGroup");
		$I->seeCheckboxIsChecked("input[name='downloadable[link][0][is_unlimited]']"); // stepKey: seeLinkMaxDownloadsUnlimitedChecked
		$I->seeInField("input[name='product[samples_title]']", "Samples"); // stepKey: seeSamplesTitle
		$I->comment("Entering Action Group [verifyDownloadableSampleLinkAdmin] AdminAssertDownloadableSampleLinkInformationActionGroup");
		$I->conditionalClick("div[data-index='downloadable']", "input[name='downloadable[sample][0][title]']", false); // stepKey: expandDownloadableSectionVerifyDownloadableSampleLinkAdmin
		$I->waitForElementVisible("input[name='downloadable[sample][0][title]']", 30); // stepKey: waitForDownloadableLinksVerifyDownloadableSampleLinkAdmin
		$I->seeInField("input[name='downloadable[sample][0][title]']", "Sample1"); // stepKey: seeTitleVerifyDownloadableSampleLinkAdmin
		$I->seeInField("select[name='downloadable[sample][0][type]']", "Upload File"); // stepKey: seeFileTypeVerifyDownloadableSampleLinkAdmin
		$grabFileNameOrUrlVerifyDownloadableSampleLinkAdmin = $I->executeJS("                     var element = document.evaluate(\"//div[@data-index='sample']//tr[@data-repeat-index='0']//fieldset[@data-index='container_sample']//div[@class='file-uploader-filename']//a|//input[@name='downloadable[sample][0][sample_url]']\", document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null);                     if ( typeof element.singleNodeValue.value !== \"undefined\" ) {                         return element.singleNodeValue.value; }                     else {                         return element.singleNodeValue.innerText; };"); // stepKey: grabFileNameOrUrlVerifyDownloadableSampleLinkAdmin
		$I->assertStringContainsString("adobe-base", $grabFileNameOrUrlVerifyDownloadableSampleLinkAdmin); // stepKey: assertFileNameOrUrlVerifyDownloadableSampleLinkAdmin
		$I->comment("Exiting Action Group [verifyDownloadableSampleLinkAdmin] AdminAssertDownloadableSampleLinkInformationActionGroup");
		$I->comment("Storefront: Verify Downloadable Product In Category");
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
		$I->amOnPage("/import-category-downloadable-file-links.html"); // stepKey: goToStorefrontCategoryPageGoToCategoryPage
		$I->comment("Exiting Action Group [goToCategoryPage] StorefrontNavigateToCategoryUrlActionGroup");
		$I->seeNumberOfElements(".product-item-name", "1"); // stepKey: seeOnly1Product2
		$I->see("import-product-downloadable-file-links", ".product-item-name"); // stepKey: seeProduct
		$I->comment("Storefront: Verify Downloadable Product Info & Image");
		$I->comment("Entering Action Group [openProductStorefrontPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/import-product-downloadable-file-links.html"); // stepKey: openProductPageOpenProductStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductStorefrontPage
		$I->comment("Exiting Action Group [openProductStorefrontPage] StorefrontOpenProductPageActionGroup");
		$I->see("import-product-downloadable-file-links", ".base"); // stepKey: seeProductName
		$I->see("import-product-downloadable-file-links", ".product.attribute.sku>.value"); // stepKey: seeSku
		$I->see("$100.00", "div.price-box.price-final_price"); // stepKey: seePrice
		$I->seeElement("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'magento-logo')]"); // stepKey: seeBaseImage
		$I->seeElement("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'm-logo')]"); // stepKey: seeSmallImage
		$I->seeElement("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'adobe-base')]"); // stepKey: seeThumbnailImage
		$I->comment("Storefront: Verify Downloadable Product Link Data");
		$I->seeElement("//dl[contains(@class,'samples')]//a[contains(.,normalize-space('Sample1'))]"); // stepKey: seeDownloadableSampleLink
		$I->waitForPageLoad(30); // stepKey: seeDownloadableSampleLinkWaitForPageLoad
		$I->click("//dl[contains(@class,'samples')]//a[contains(.,normalize-space('Sample1'))]"); // stepKey: clickDownloadableSampleLink
		$I->waitForPageLoad(30); // stepKey: clickDownloadableSampleLinkWaitForPageLoad
		$I->switchToNextTab(); // stepKey: switchToDownloadedLinkTab
		$I->waitForElement("body>img", 30); // stepKey: seeImage
		$I->closeTab(); // stepKey: closeTab
		$I->seeElement("//*[@id='downloadable-links-list']/*[contains(.,'Link1')]//input"); // stepKey: seeDownloadableLink
		$I->waitForPageLoad(30); // stepKey: seeDownloadableLinkWaitForPageLoad
		$I->seeElement("//label[contains(., 'sample')]/a[contains(@class, 'sample link')]"); // stepKey: seeDownloadableLinkSampleLink
		$I->click("//label[contains(., 'sample')]/a[contains(@class, 'sample link')]"); // stepKey: clickDownloadableLinkSampleLink
		$I->switchToNextTab(); // stepKey: switchToDownloadedLinkTab2
		$I->waitForElement("body>img", 30); // stepKey: seeImage2
		$I->closeTab(); // stepKey: closeTab2
		$I->checkOption("//*[@id='downloadable-links-list']/*[contains(.,'Link1')]//input"); // stepKey: selectDownloadableLink
		$I->waitForPageLoad(30); // stepKey: selectDownloadableLinkWaitForPageLoad
		$I->waitForText("$103.00", 30, "div.price-box.price-final_price"); // stepKey: seeUpdatedPrice
		$I->comment("Purchase Downloadable Product");
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
		$I->comment("Create Invoice");
		$I->comment("Entering Action Group [goToOrderInAdmin] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageGoToOrderInAdmin
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageGoToOrderInAdmin
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersGoToOrderInAdmin
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersGoToOrderInAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersGoToOrderInAdmin
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersGoToOrderInAdmin
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersGoToOrderInAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersGoToOrderInAdmin
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $grabOrderNumber); // stepKey: fillOrderIdFilterGoToOrderInAdmin
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersGoToOrderInAdmin
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersGoToOrderInAdminWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageGoToOrderInAdmin
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageGoToOrderInAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedGoToOrderInAdmin
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersGoToOrderInAdmin
		$I->comment("Exiting Action Group [goToOrderInAdmin] OpenOrderByIdActionGroup");
		$I->comment("Entering Action Group [startInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->click("#order_invoice"); // stepKey: clickInvoiceActionStartInvoice
		$I->waitForPageLoad(30); // stepKey: clickInvoiceActionStartInvoiceWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order_invoice/new/order_id/"); // stepKey: seeNewInvoiceUrlStartInvoice
		$I->see("New Invoice", ".page-header h1.page-title"); // stepKey: seeNewInvoicePageTitleStartInvoice
		$I->comment("Exiting Action Group [startInvoice] StartCreateInvoiceFromOrderPageActionGroup");
		$I->comment("Entering Action Group [submitInvoice] SubmitInvoiceActionGroup");
		$I->click(".action-default.scalable.save.submit-button.primary"); // stepKey: clickSubmitInvoiceSubmitInvoice
		$I->waitForPageLoad(60); // stepKey: clickSubmitInvoiceSubmitInvoiceWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageAppearsSubmitInvoice
		$I->see("The invoice has been created.", "#messages div.message-success"); // stepKey: seeInvoiceCreateSuccessSubmitInvoice
		$grabOrderIdSubmitInvoice = $I->grabFromCurrentUrl("~/order_id/(\d+)/~"); // stepKey: grabOrderIdSubmitInvoice
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/"); // stepKey: seeViewOrderPageInvoiceSubmitInvoice
		$I->comment("Exiting Action Group [submitInvoice] SubmitInvoiceActionGroup");
		$I->comment("Storefront: Go to Purchased Downloadable Product & Verify Link");
		$I->comment("Entering Action Group [goToCustomerDownloadableProductsPage] StorefrontNavigateToCustomerDownloadableProductsPageActionGroup");
		$I->amOnPage("downloadable/customer/products/"); // stepKey: navigateToImportPageGoToCustomerDownloadableProductsPage
		$I->waitForText("My Downloadable Products", 30, "#maincontent .column.main [data-ui-id='page-title-wrapper']"); // stepKey: waitForPageTitleGoToCustomerDownloadableProductsPage
		$I->comment("Exiting Action Group [goToCustomerDownloadableProductsPage] StorefrontNavigateToCustomerDownloadableProductsPageActionGroup");
		$I->see("Link1", "//table[@id='my-downloadable-products-table']//td[@data-th='Order #']//a[contains(.,'{$grabOrderNumber}')]/ancestor::tr//a[contains(@class, 'download')]"); // stepKey: seeDownloadableLink2
		$I->click("//table[@id='my-downloadable-products-table']//td[@data-th='Order #']//a[contains(.,'{$grabOrderNumber}')]/ancestor::tr//a[contains(@class, 'download')]"); // stepKey: clickDownloadableLink
		$I->switchToNextTab(); // stepKey: switchToDownloadedLinkTab3
		$I->waitForElement("body>img", 30); // stepKey: seeImage3
		$I->closeTab(); // stepKey: closeTab3
		$I->comment("Import Downloadable Product");
	}
}
