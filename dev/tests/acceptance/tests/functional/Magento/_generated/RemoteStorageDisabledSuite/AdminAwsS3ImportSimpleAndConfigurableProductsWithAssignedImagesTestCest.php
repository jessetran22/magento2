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
 * @Title("[NO TESTCASEID]: S3 - Import Configurable Product With Simple Child Products With Images")
 * @Description("Imports a .csv file containing a configurable product with 3 child simple products that             have images. Verifies that products are imported successfully and that the images are attached to the             products as expected.<h3>Test files</h3>app/code/Magento/AwsS3/Test/Mftf/Test/AdminAwsS3ImportSimpleAndConfigurableProductsWithAssignedImagesTest.xml<br>")
 * @group importExport
 * @group ConfigurableProduct
 * @group remote_storage_aws_s3
 * @group remote_storage_disabled
 */
class AdminAwsS3ImportSimpleAndConfigurableProductsWithAssignedImagesTestCest
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
        $this->helperContainer->create("Magento\Backend\Test\Mftf\Helper\CurlHelpers");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
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
		$I->comment("Create Category, Product Attribute with 3 Options, & Customer");
		$I->createEntity("createImportCategory", "hook", "ImportCategory_Configurable", [], []); // stepKey: createImportCategory
		$I->createEntity("createImportProductAttribute", "hook", "ProductAttributeWithThreeOptionsForImport", [], []); // stepKey: createImportProductAttribute
		$I->createEntity("createImportProductAttributeOption1", "hook", "ProductAttributeOptionOneForExportImport", ["createImportProductAttribute"], []); // stepKey: createImportProductAttributeOption1
		$I->createEntity("createImportProductAttributeOption2", "hook", "ProductAttributeOptionTwoForExportImport", ["createImportProductAttribute"], []); // stepKey: createImportProductAttributeOption2
		$I->createEntity("createImportProductAttributeOption3", "hook", "ProductAttributeOptionThreeForImport", ["createImportProductAttribute"], []); // stepKey: createImportProductAttributeOption3
		$I->createEntity("addToProductAttributeSet", "hook", "AddToDefaultSet", ["createImportProductAttribute"], []); // stepKey: addToProductAttributeSet
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment('[createDirectoryForImportFiles] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::createDirectory()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->createDirectory("pub/media/import/import-product-configurable", 511); // stepKey: createDirectoryForImportFiles
		$I->comment('[copyImportFile] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/import_configurable_product.csv", "pub/media/import/import-product-configurable/import_configurable_product.csv"); // stepKey: copyImportFile
		$I->comment("Copy Images to Import Directory for Product Images");
		$I->comment('[copyProduct1BaseImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/magento-logo.png", "pub/media/import/import-product-configurable/magento-logo.png"); // stepKey: copyProduct1BaseImage
		$I->comment('[copyProduct2BaseImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/m-logo.gif", "pub/media/import/import-product-configurable/m-logo.gif"); // stepKey: copyProduct2BaseImage
		$I->comment('[copyProduct3BaseImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/adobe-base.jpg", "pub/media/import/import-product-configurable/adobe-base.jpg"); // stepKey: copyProduct3BaseImage
		$enableRemoteStorage = $I->magentoCLI("setup:config:set --remote-storage-driver=" . getenv("REMOTE_STORAGE_AWSS3_DRIVER") . " --remote-storage-bucket=" . getenv("REMOTE_STORAGE_AWSS3_BUCKET") . " --remote-storage-region=" . getenv("REMOTE_STORAGE_AWSS3_REGION") . " --remote-storage-prefix=" . getenv("REMOTE_STORAGE_AWSS3_PREFIX") . " --remote-storage-key=" . getenv("REMOTE_STORAGE_AWSS3_ACCESS_KEY") . " --remote-storage-secret=" . getenv("REMOTE_STORAGE_AWSS3_SECRET_KEY") . " -n", 60); // stepKey: enableRemoteStorage
		$I->comment($enableRemoteStorage);
		$syncRemoteStorage = $I->magentoCLI("remote-storage:sync", 120); // stepKey: syncRemoteStorage
		$I->comment($syncRemoteStorage);
		$I->comment('[createDirectoryForImportFilesInS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::createDirectory()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->createDirectory("var/import/images/import-product-configurable", 511); // stepKey: createDirectoryForImportFilesInS3
		$I->comment('[copyProduct1BaseImageInS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::copy()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->copy("media/import/import-product-configurable/magento-logo.png", "var/import/images/import-product-configurable/magento-logo.png"); // stepKey: copyProduct1BaseImageInS3
		$I->comment('[copyProduct2BaseImageInS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::copy()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->copy("media/import/import-product-configurable/m-logo.gif", "var/import/images/import-product-configurable/m-logo.gif"); // stepKey: copyProduct2BaseImageInS3
		$I->comment('[copyProduct3BaseImageInS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::copy()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->copy("media/import/import-product-configurable/adobe-base.jpg", "var/import/images/import-product-configurable/adobe-base.jpg"); // stepKey: copyProduct3BaseImageInS3
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
		$I->comment("Entering Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageOpenProductIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadOpenProductIndexPage
		$I->comment("Exiting Action Group [openProductIndexPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [filterProductsGrid] AdminGridFilterFillInputFieldActionGroup");
		$I->conditionalClick("//div[@class='admin__data-grid-header'][(not(ancestor::*[@class='sticky-header']) and not(contains(@style,'visibility: hidden'))) or (ancestor::*[@class='sticky-header' and not(contains(@style,'display: none'))])]//button[@data-action='grid-filter-expand']", "[data-part='filter-form']", false); // stepKey: openFiltersFormIfNecessaryFilterProductsGrid
		$I->waitForElementVisible("[data-part='filter-form']", 30); // stepKey: waitForFormVisibleFilterProductsGrid
		$I->fillField("//*[@data-part='filter-form']//input[@name='sku']", "import-product-configurable"); // stepKey: fillFilterInputFieldFilterProductsGrid
		$I->comment("Exiting Action Group [filterProductsGrid] AdminGridFilterFillInputFieldActionGroup");
		$I->comment("Entering Action Group [applyProductsFilter] AdminGridFilterApplyActionGroup");
		$I->click("//*[@data-part='filter-form']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyProductsFilter
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetApplyProductsFilter
		$I->comment("Exiting Action Group [applyProductsFilter] AdminGridFilterApplyActionGroup");
		$I->comment("Entering Action Group [deleteProducts] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteProducts
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteProducts
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProducts
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductsWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProducts
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductsWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteProducts
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteProductsWaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProducts
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteProducts
		$I->comment("Exiting Action Group [deleteProducts] DeleteProductsIfTheyExistActionGroup");
		$I->comment("Entering Action Group [filterProductsGrid2] AdminGridFilterFillInputFieldActionGroup");
		$I->conditionalClick("//div[@class='admin__data-grid-header'][(not(ancestor::*[@class='sticky-header']) and not(contains(@style,'visibility: hidden'))) or (ancestor::*[@class='sticky-header' and not(contains(@style,'display: none'))])]//button[@data-action='grid-filter-expand']", "[data-part='filter-form']", false); // stepKey: openFiltersFormIfNecessaryFilterProductsGrid2
		$I->waitForElementVisible("[data-part='filter-form']", 30); // stepKey: waitForFormVisibleFilterProductsGrid2
		$I->fillField("//*[@data-part='filter-form']//input[@name='sku']", "import-product"); // stepKey: fillFilterInputFieldFilterProductsGrid2
		$I->comment("Exiting Action Group [filterProductsGrid2] AdminGridFilterFillInputFieldActionGroup");
		$I->comment("Entering Action Group [applyProductsFilter2] AdminGridFilterApplyActionGroup");
		$I->click("//*[@data-part='filter-form']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyProductsFilter2
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetApplyProductsFilter2
		$I->comment("Exiting Action Group [applyProductsFilter2] AdminGridFilterApplyActionGroup");
		$I->comment("Entering Action Group [deleteProducts2] DeleteProductsIfTheyExistActionGroup");
		$I->conditionalClick("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle", "table.data-grid tr.data-row:first-of-type", true); // stepKey: openMulticheckDropdownDeleteProducts2
		$I->conditionalClick("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']", "table.data-grid tr.data-row:first-of-type", true); // stepKey: selectAllProductInFilteredGridDeleteProducts2
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProducts2
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProducts2WaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProducts2
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProducts2WaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm button.action-accept", 30); // stepKey: waitForModalPopUpDeleteProducts2
		$I->waitForPageLoad(60); // stepKey: waitForModalPopUpDeleteProducts2WaitForPageLoad
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProducts2
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProducts2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForGridLoadDeleteProducts2
		$I->comment("Exiting Action Group [deleteProducts2] DeleteProductsIfTheyExistActionGroup");
		$I->comment("Entering Action Group [resetProductsGrid] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopResetProductsGrid
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersResetProductsGrid
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetResetProductsGrid
		$I->comment("Exiting Action Group [resetProductsGrid] AdminGridFilterResetActionGroup");
		$I->comment("Entering Action Group [deleteAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute"); // stepKey: navigateToProductAttributeGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: waitForProductAttributeGridPageLoadDeleteAttribute
		$I->click("button[data-action='grid-filter-reset']"); // stepKey: resetFiltersOnGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: resetFiltersOnGridDeleteAttributeWaitForPageLoad
		$I->fillField("//input[@name='frontend_label']", "import_attribute1"); // stepKey: setAttributeLabelFilterDeleteAttribute
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: searchForAttributeLabelFromTheGridDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: searchForAttributeLabelFromTheGridDeleteAttributeWaitForPageLoad
		$I->click("//*[@id='attributeGrid_table']/tbody/tr[1]"); // stepKey: clickOnAttributeRowDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnAttributeRowDeleteAttributeWaitForPageLoad
		$I->click("#delete"); // stepKey: clickOnDeleteAttributeButtonDeleteAttribute
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteAttributeButtonDeleteAttributeWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmationPopUpVisibleDeleteAttribute
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOnConfirmationButtonDeleteAttribute
		$I->waitForPageLoad(60); // stepKey: clickOnConfirmationButtonDeleteAttributeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageVisibleDeleteAttribute
		$I->see("You deleted the product attribute.", "#messages div.message-success"); // stepKey: seeAttributeDeleteSuccessMessageDeleteAttribute
		$I->comment("Exiting Action Group [deleteAttribute] AdminDeleteProductAttributeByLabelActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment('[deleteImportFilesDirectoryS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::deleteDirectory()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->deleteDirectory("media/import/import-product-configurable"); // stepKey: deleteImportFilesDirectoryS3
		$I->comment('[deleteImportImagesFilesDirectoryS3] Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions::deleteDirectory()');
		$this->helperContainer->get('Magento\AwsS3\Test\Mftf\Helper\S3FileAssertions')->deleteDirectory("var/import/images/import-product-configurable"); // stepKey: deleteImportImagesFilesDirectoryS3
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$disableRemoteStorage = $I->magentoCLI("setup:config:set --remote-storage-driver=file -n", 60); // stepKey: disableRemoteStorage
		$I->comment($disableRemoteStorage);
		$I->comment('[deleteImportFilesDirectoryLocal] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::deleteDirectory()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->deleteDirectory("pub/media/import/import-product-configurable"); // stepKey: deleteImportFilesDirectoryLocal
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
	public function AdminAwsS3ImportSimpleAndConfigurableProductsWithAssignedImagesTest(AcceptanceTester $I)
	{
		$I->comment("Import Configurable Product with Simple Child Products & Assert No Errors");
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
		$I->attachFile("#import_file", "import_configurable_product.csv"); // stepKey: attachFileForImportFillImportForm
		$I->fillField("#import_images_file_dir", "import-product-configurable"); // stepKey: fillImagesFileDirectoryFieldFillImportForm
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
		$I->see("import_configurable_product.csv", "table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: seeImportedFile
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
		$I->fillField("input.admin__control-text[name='sku']", "import-product-simple1-configurable"); // stepKey: fillProductSkuFilterGoToSimpleProduct1EditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToSimpleProduct1EditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToSimpleProduct1EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToSimpleProduct1EditPage
		$I->click("//td/div[text()='import-product-simple1-configurable']"); // stepKey: clickProductGoToSimpleProduct1EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToSimpleProduct1EditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToSimpleProduct1EditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-simple1-configurable"); // stepKey: seeProductSKUGoToSimpleProduct1EditPage
		$I->comment("Exiting Action Group [goToSimpleProduct1EditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct1OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertSimpleProduct1OnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertSimpleProduct1OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertSimpleProduct1OnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-simple1-configurable"); // stepKey: seeProductNameAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-simple1-configurable"); // stepKey: seeProductSkuAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "11.00"); // stepKey: seeProductPriceAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "101"); // stepKey: seeProductQuantityAssertSimpleProduct1OnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertSimpleProduct1OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertSimpleProduct1OnEditPageWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", "1"); // stepKey: seeProductWeightAssertSimpleProduct1OnEditPage
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Not Visible Individually"); // stepKey: seeProductVisibilityAssertSimpleProduct1OnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-configurable')]"); // stepKey: seeProductCategoriesAssertSimpleProduct1OnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct1OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->comment("Entering Action Group [assertProduct1BaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProduct1BaseImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProduct1BaseImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertProduct1BaseImageOnEditPage
		$I->comment("Exiting Action Group [assertProduct1BaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='image']"); // stepKey: seeBaseImageRole1
		$I->comment("Entering Action Group [assertProduct1SmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProduct1SmallImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProduct1SmallImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertProduct1SmallImageOnEditPage
		$I->comment("Exiting Action Group [assertProduct1SmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='small_image']"); // stepKey: seeSmallImageRole1
		$I->comment("Entering Action Group [assertProduct1ThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProduct1ThumbnailImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProduct1ThumbnailImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertProduct1ThumbnailImageOnEditPage
		$I->comment("Exiting Action Group [assertProduct1ThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='thumbnail']"); // stepKey: seeThumbnailImageRole1
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
		$I->fillField("input.admin__control-text[name='sku']", "import-product-simple2-configurable"); // stepKey: fillProductSkuFilterGoToSimpleProduct2EditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToSimpleProduct2EditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToSimpleProduct2EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToSimpleProduct2EditPage
		$I->click("//td/div[text()='import-product-simple2-configurable']"); // stepKey: clickProductGoToSimpleProduct2EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToSimpleProduct2EditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToSimpleProduct2EditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-simple2-configurable"); // stepKey: seeProductSKUGoToSimpleProduct2EditPage
		$I->comment("Exiting Action Group [goToSimpleProduct2EditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct2OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertSimpleProduct2OnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertSimpleProduct2OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertSimpleProduct2OnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-simple2-configurable"); // stepKey: seeProductNameAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-simple2-configurable"); // stepKey: seeProductSkuAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "12.00"); // stepKey: seeProductPriceAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "102"); // stepKey: seeProductQuantityAssertSimpleProduct2OnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertSimpleProduct2OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertSimpleProduct2OnEditPageWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", "2"); // stepKey: seeProductWeightAssertSimpleProduct2OnEditPage
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Not Visible Individually"); // stepKey: seeProductVisibilityAssertSimpleProduct2OnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-configurable')]"); // stepKey: seeProductCategoriesAssertSimpleProduct2OnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct2OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->comment("Entering Action Group [assertProduct2BaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProduct2BaseImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProduct2BaseImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]", 30); // stepKey: seeImageAssertProduct2BaseImageOnEditPage
		$I->comment("Exiting Action Group [assertProduct2BaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='image']"); // stepKey: seeBaseImageRole2
		$I->comment("Entering Action Group [assertProduct2SmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProduct2SmallImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProduct2SmallImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]", 30); // stepKey: seeImageAssertProduct2SmallImageOnEditPage
		$I->comment("Exiting Action Group [assertProduct2SmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='small_image']"); // stepKey: seeSmallImageRole2
		$I->comment("Entering Action Group [assertProduct2ThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProduct2ThumbnailImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProduct2ThumbnailImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]", 30); // stepKey: seeImageAssertProduct2ThumbnailImageOnEditPage
		$I->comment("Exiting Action Group [assertProduct2ThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='thumbnail']"); // stepKey: seeThumbnailImageRole2
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
		$I->fillField("input.admin__control-text[name='sku']", "import-product-simple3-configurable"); // stepKey: fillProductSkuFilterGoToSimpleProduct3EditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToSimpleProduct3EditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToSimpleProduct3EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToSimpleProduct3EditPage
		$I->click("//td/div[text()='import-product-simple3-configurable']"); // stepKey: clickProductGoToSimpleProduct3EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToSimpleProduct3EditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToSimpleProduct3EditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-simple3-configurable"); // stepKey: seeProductSKUGoToSimpleProduct3EditPage
		$I->comment("Exiting Action Group [goToSimpleProduct3EditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct3OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertSimpleProduct3OnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertSimpleProduct3OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertSimpleProduct3OnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-simple3-configurable"); // stepKey: seeProductNameAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-simple3-configurable"); // stepKey: seeProductSkuAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "13.00"); // stepKey: seeProductPriceAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "103"); // stepKey: seeProductQuantityAssertSimpleProduct3OnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertSimpleProduct3OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertSimpleProduct3OnEditPageWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", "3"); // stepKey: seeProductWeightAssertSimpleProduct3OnEditPage
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Not Visible Individually"); // stepKey: seeProductVisibilityAssertSimpleProduct3OnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-configurable')]"); // stepKey: seeProductCategoriesAssertSimpleProduct3OnEditPage
		$I->comment("Exiting Action Group [assertSimpleProduct3OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->comment("Entering Action Group [assertProduct3BaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProduct3BaseImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProduct3BaseImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertProduct3BaseImageOnEditPage
		$I->comment("Exiting Action Group [assertProduct3BaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='image']"); // stepKey: seeBaseImageRole3
		$I->comment("Entering Action Group [assertProduct3SmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProduct3SmallImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProduct3SmallImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertProduct3SmallImageOnEditPage
		$I->comment("Exiting Action Group [assertProduct3SmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='small_image']"); // stepKey: seeSmallImageRole3
		$I->comment("Entering Action Group [assertProduct3ThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertProduct3ThumbnailImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertProduct3ThumbnailImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertProduct3ThumbnailImageOnEditPage
		$I->comment("Exiting Action Group [assertProduct3ThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='thumbnail']"); // stepKey: seeThumbnailImageRole3
		$I->comment("Admin: Verify Configurable Product Common Data on Edit Product Page");
		$I->comment("Entering Action Group [goToConfigurableProductEditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageGoToConfigurableProductEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadGoToConfigurableProductEditPage
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersGoToConfigurableProductEditPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersGoToConfigurableProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersGoToConfigurableProductEditPage
		$I->dontSeeElement(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: dontSeeClearFiltersGoToConfigurableProductEditPage
		$I->waitForPageLoad(30); // stepKey: dontSeeClearFiltersGoToConfigurableProductEditPageWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabGoToConfigurableProductEditPage
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewGoToConfigurableProductEditPage
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewGoToConfigurableProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetToDefaultViewGoToConfigurableProductEditPage
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedGoToConfigurableProductEditPage
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersGoToConfigurableProductEditPage
		$I->fillField("input.admin__control-text[name='sku']", "import-product-configurable"); // stepKey: fillProductSkuFilterGoToConfigurableProductEditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToConfigurableProductEditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToConfigurableProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToConfigurableProductEditPage
		$I->click("//td/div[text()='import-product-configurable']"); // stepKey: clickProductGoToConfigurableProductEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToConfigurableProductEditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToConfigurableProductEditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-configurable"); // stepKey: seeProductSKUGoToConfigurableProductEditPage
		$I->comment("Exiting Action Group [goToConfigurableProductEditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductOnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertConfigurableProductOnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertConfigurableProductOnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertConfigurableProductOnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetAssertConfigurableProductOnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-configurable"); // stepKey: seeProductNameAssertConfigurableProductOnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-configurable"); // stepKey: seeProductSkuAssertConfigurableProductOnEditPage
		$I->seeInField(".admin__field[data-index=price] input", ""); // stepKey: seeProductPriceAssertConfigurableProductOnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", ""); // stepKey: seeProductQuantityAssertConfigurableProductOnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertConfigurableProductOnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertConfigurableProductOnEditPageWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", ""); // stepKey: seeProductWeightAssertConfigurableProductOnEditPage
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeProductVisibilityAssertConfigurableProductOnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-configurable')]"); // stepKey: seeProductCategoriesAssertConfigurableProductOnEditPage
		$I->comment("Exiting Action Group [assertConfigurableProductOnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->comment("Entering Action Group [assertConfigurableProductBaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertConfigurableProductBaseImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertConfigurableProductBaseImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertConfigurableProductBaseImageOnEditPage
		$I->comment("Exiting Action Group [assertConfigurableProductBaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='image']"); // stepKey: seeBaseImageRoleConfigurable
		$I->comment("Entering Action Group [assertConfigurableProductSmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertConfigurableProductSmallImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertConfigurableProductSmallImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertConfigurableProductSmallImageOnEditPage
		$I->comment("Exiting Action Group [assertConfigurableProductSmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='small_image']"); // stepKey: seeSmallImageRoleConfigurable
		$I->comment("Entering Action Group [assertConfigurableProductThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertConfigurableProductThumbnailImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertConfigurableProductThumbnailImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertConfigurableProductThumbnailImageOnEditPage
		$I->comment("Exiting Action Group [assertConfigurableProductThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='thumbnail']"); // stepKey: seeThumbnailImageRoleConfigurable
		$I->comment("Admin: Verify Configurable Product Information on Edit Product Page");
		$I->seeNumberOfElements("[data-index=configurable-matrix] .data-row", "3"); // stepKey: see3RowsAdmin
		$I->comment("Entering Action Group [verifyConfigurableChildProduct1Admin] AdminVerifyCurrentVariationsForConfigurableProductActionGroup");
		$I->waitForElementVisible("[data-index=configurable-matrix] .data-row:nth-of-type(1) td[data-index=thumbnail_image_container] img", 30); // stepKey: waitForProductImageVerifyConfigurableChildProduct1Admin
		$grabProductImageSrcVerifyConfigurableChildProduct1Admin = $I->grabAttributeFrom("[data-index=configurable-matrix] .data-row:nth-of-type(1) td[data-index=thumbnail_image_container] img", "src"); // stepKey: grabProductImageSrcVerifyConfigurableChildProduct1Admin
		$I->assertStringContainsString("magento-logo", $grabProductImageSrcVerifyConfigurableChildProduct1Admin); // stepKey: assertProductImageSrcVerifyConfigurableChildProduct1Admin
		$I->see("import-product-simple1-configurable", "[data-index=configurable-matrix] .data-row:nth-of-type(1) td[data-index=name_container]"); // stepKey: seeProductNameVerifyConfigurableChildProduct1Admin
		$I->see("import-product-simple1-configurable", "[data-index=configurable-matrix] .data-row:nth-of-type(1) td[data-index=sku_container]"); // stepKey: seeProductSkuVerifyConfigurableChildProduct1Admin
		$I->see("$11.00", "[data-index=configurable-matrix] .data-row:nth-of-type(1) td[data-index=price_container]"); // stepKey: seeProductPriceVerifyConfigurableChildProduct1Admin
		$I->see("101", "[data-index=configurable-matrix] .data-row:nth-of-type(1) td[data-index=quantity_container]"); // stepKey: seeProductQuantityVerifyConfigurableChildProduct1Admin
		$I->see("1", "[data-index=configurable-matrix] .data-row:nth-of-type(1) td[data-index=price_weight]"); // stepKey: seeProductWeightVerifyConfigurableChildProduct1Admin
		$I->see("Enabled", "[data-index=configurable-matrix] .data-row:nth-of-type(1) td[data-index=status]"); // stepKey: seeProductStatusVerifyConfigurableChildProduct1Admin
		$I->see("import_attribute1: option1", "[data-index=configurable-matrix] .data-row:nth-of-type(1) td[data-index=attributes]"); // stepKey: seeProductAttributesVerifyConfigurableChildProduct1Admin
		$I->comment("Exiting Action Group [verifyConfigurableChildProduct1Admin] AdminVerifyCurrentVariationsForConfigurableProductActionGroup");
		$I->comment("Entering Action Group [verifyConfigurableChildProduct2Admin] AdminVerifyCurrentVariationsForConfigurableProductActionGroup");
		$I->waitForElementVisible("[data-index=configurable-matrix] .data-row:nth-of-type(2) td[data-index=thumbnail_image_container] img", 30); // stepKey: waitForProductImageVerifyConfigurableChildProduct2Admin
		$grabProductImageSrcVerifyConfigurableChildProduct2Admin = $I->grabAttributeFrom("[data-index=configurable-matrix] .data-row:nth-of-type(2) td[data-index=thumbnail_image_container] img", "src"); // stepKey: grabProductImageSrcVerifyConfigurableChildProduct2Admin
		$I->assertStringContainsString("m-logo", $grabProductImageSrcVerifyConfigurableChildProduct2Admin); // stepKey: assertProductImageSrcVerifyConfigurableChildProduct2Admin
		$I->see("import-product-simple2-configurable", "[data-index=configurable-matrix] .data-row:nth-of-type(2) td[data-index=name_container]"); // stepKey: seeProductNameVerifyConfigurableChildProduct2Admin
		$I->see("import-product-simple2-configurable", "[data-index=configurable-matrix] .data-row:nth-of-type(2) td[data-index=sku_container]"); // stepKey: seeProductSkuVerifyConfigurableChildProduct2Admin
		$I->see("$12.00", "[data-index=configurable-matrix] .data-row:nth-of-type(2) td[data-index=price_container]"); // stepKey: seeProductPriceVerifyConfigurableChildProduct2Admin
		$I->see("102", "[data-index=configurable-matrix] .data-row:nth-of-type(2) td[data-index=quantity_container]"); // stepKey: seeProductQuantityVerifyConfigurableChildProduct2Admin
		$I->see("2", "[data-index=configurable-matrix] .data-row:nth-of-type(2) td[data-index=price_weight]"); // stepKey: seeProductWeightVerifyConfigurableChildProduct2Admin
		$I->see("Enabled", "[data-index=configurable-matrix] .data-row:nth-of-type(2) td[data-index=status]"); // stepKey: seeProductStatusVerifyConfigurableChildProduct2Admin
		$I->see("import_attribute1: option2", "[data-index=configurable-matrix] .data-row:nth-of-type(2) td[data-index=attributes]"); // stepKey: seeProductAttributesVerifyConfigurableChildProduct2Admin
		$I->comment("Exiting Action Group [verifyConfigurableChildProduct2Admin] AdminVerifyCurrentVariationsForConfigurableProductActionGroup");
		$I->comment("Entering Action Group [verifyConfigurableChildProduct3Admin] AdminVerifyCurrentVariationsForConfigurableProductActionGroup");
		$I->waitForElementVisible("[data-index=configurable-matrix] .data-row:nth-of-type(3) td[data-index=thumbnail_image_container] img", 30); // stepKey: waitForProductImageVerifyConfigurableChildProduct3Admin
		$grabProductImageSrcVerifyConfigurableChildProduct3Admin = $I->grabAttributeFrom("[data-index=configurable-matrix] .data-row:nth-of-type(3) td[data-index=thumbnail_image_container] img", "src"); // stepKey: grabProductImageSrcVerifyConfigurableChildProduct3Admin
		$I->assertStringContainsString("adobe-base", $grabProductImageSrcVerifyConfigurableChildProduct3Admin); // stepKey: assertProductImageSrcVerifyConfigurableChildProduct3Admin
		$I->see("import-product-simple3-configurable", "[data-index=configurable-matrix] .data-row:nth-of-type(3) td[data-index=name_container]"); // stepKey: seeProductNameVerifyConfigurableChildProduct3Admin
		$I->see("import-product-simple3-configurable", "[data-index=configurable-matrix] .data-row:nth-of-type(3) td[data-index=sku_container]"); // stepKey: seeProductSkuVerifyConfigurableChildProduct3Admin
		$I->see("$13.00", "[data-index=configurable-matrix] .data-row:nth-of-type(3) td[data-index=price_container]"); // stepKey: seeProductPriceVerifyConfigurableChildProduct3Admin
		$I->see("103", "[data-index=configurable-matrix] .data-row:nth-of-type(3) td[data-index=quantity_container]"); // stepKey: seeProductQuantityVerifyConfigurableChildProduct3Admin
		$I->see("3", "[data-index=configurable-matrix] .data-row:nth-of-type(3) td[data-index=price_weight]"); // stepKey: seeProductWeightVerifyConfigurableChildProduct3Admin
		$I->see("Enabled", "[data-index=configurable-matrix] .data-row:nth-of-type(3) td[data-index=status]"); // stepKey: seeProductStatusVerifyConfigurableChildProduct3Admin
		$I->see("import_attribute1: option3", "[data-index=configurable-matrix] .data-row:nth-of-type(3) td[data-index=attributes]"); // stepKey: seeProductAttributesVerifyConfigurableChildProduct3Admin
		$I->comment("Exiting Action Group [verifyConfigurableChildProduct3Admin] AdminVerifyCurrentVariationsForConfigurableProductActionGroup");
		$I->comment("Storefront: Verify Configurable Product In Category");
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
		$I->amOnPage("/import-category-configurable.html"); // stepKey: goToStorefrontCategoryPageGoToCategoryPage
		$I->comment("Exiting Action Group [goToCategoryPage] StorefrontNavigateToCategoryUrlActionGroup");
		$I->seeNumberOfElements(".product-item-name", "1"); // stepKey: seeOnly1Product
		$I->see("import-product-configurable", ".product-item-name"); // stepKey: seeConfigurableProduct
		$I->dontSee("import-product-simple1-configurable", "#maincontent .column.main"); // stepKey: dontSeeSimpleProduct1
		$I->dontSee("import-product-simple2-configurable", "#maincontent .column.main"); // stepKey: dontSeeSimpleProduct2
		$I->dontSee("import-product-simple3-configurable", "#maincontent .column.main"); // stepKey: dontSeeSimpleProduct3
		$I->comment("Storefront: Verify Configurable Product Info & Image");
		$I->comment("Entering Action Group [openProductStorefrontPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/import-product-configurable.html"); // stepKey: openProductPageOpenProductStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductStorefrontPage
		$I->comment("Exiting Action Group [openProductStorefrontPage] StorefrontOpenProductPageActionGroup");
		$I->see("import-product-configurable", ".base"); // stepKey: seeProductName
		$I->see("import-product-configurable", ".product.attribute.sku>.value"); // stepKey: seeSku
		$I->see("As low as $11.00", "div.price-box.price-final_price"); // stepKey: seePrice
		$I->seeElement("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'adobe-base')]"); // stepKey: seeBaseImage
		$I->comment("Storefront: Verify Configurable Product Option 1 Info & Image");
		$I->comment("Entering Action Group [selectOption1] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'import_attribute1')]/../div[@class='control']//select", "option1"); // stepKey: fillDropDownAttributeOptionSelectOption1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectOption1
		$I->comment("Exiting Action Group [selectOption1] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->see("import-product-configurable", ".base"); // stepKey: seeProductName2
		$I->see("import-product-configurable", ".product.attribute.sku>.value"); // stepKey: seeSku2
		$I->see("$11.00", "div.price-box.price-final_price"); // stepKey: seePrice2
		$I->waitForPageLoad(30); // stepKey: waitForImageLoad1
		$I->waitForElementVisible("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeBaseImage2
		$I->comment("Storefront: Verify Configurable Product Option 2 Info & Image");
		$I->comment("Entering Action Group [selectOption2] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'import_attribute1')]/../div[@class='control']//select", "option2"); // stepKey: fillDropDownAttributeOptionSelectOption2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectOption2
		$I->comment("Exiting Action Group [selectOption2] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->see("import-product-configurable", ".base"); // stepKey: seeProductName3
		$I->see("import-product-configurable", ".product.attribute.sku>.value"); // stepKey: seeSku3
		$I->see("$12.00", "div.price-box.price-final_price"); // stepKey: seePrice3
		$I->waitForPageLoad(30); // stepKey: waitForImageLoad2
		$I->waitForElementVisible("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'm-logo')]", 30); // stepKey: seeBaseImage3
		$I->comment("Storefront: Verify Configurable Product Option 3 Info & Image");
		$I->comment("Entering Action Group [selectOption3] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'import_attribute1')]/../div[@class='control']//select", "option3"); // stepKey: fillDropDownAttributeOptionSelectOption3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectOption3
		$I->comment("Exiting Action Group [selectOption3] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->see("import-product-configurable", ".base"); // stepKey: seeProductName4
		$I->see("import-product-configurable", ".product.attribute.sku>.value"); // stepKey: seeSku4
		$I->see("$13.00", "div.price-box.price-final_price"); // stepKey: seePrice4
		$I->waitForPageLoad(30); // stepKey: waitForImageLoad3
		$I->waitForElementVisible("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeBaseImage4
		$I->comment("Purchase Configurable Product");
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
		$I->comment("Confirm Purchased Configurable Product");
		$I->comment("Entering Action Group [openOrderFromSuccessPage] StorefrontOpenOrderFromSuccessPageActionGroup");
		$I->click("//div[contains(@class,'success')]//a[contains(.,'{$grabOrderNumber}')]"); // stepKey: clickOrderNumberLinkOpenOrderFromSuccessPage
		$I->waitForPageLoad(30); // stepKey: clickOrderNumberLinkOpenOrderFromSuccessPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageIsLoadedOpenOrderFromSuccessPage
		$I->see("Order # {$grabOrderNumber}", ".page-title span"); // stepKey: assertOrderNumberIsCorrectOpenOrderFromSuccessPage
		$I->comment("Exiting Action Group [openOrderFromSuccessPage] StorefrontOpenOrderFromSuccessPageActionGroup");
		$I->seeNumberOfElements("#my-orders-table tbody tr", "1"); // stepKey: seeOnly1ProductInOrder
		$I->comment("Entering Action Group [verifyProductRowInOrder] StorefrontVerifyCustomerOrderProductRowDataActionGroup");
		$I->waitForText("import-product-configurable", 30, "#my-orders-table tbody:nth-of-type(1) td.name"); // stepKey: seeProductNameVerifyProductRowInOrder
		$I->waitForText("import-product-simple3-configurable", 30, "#my-orders-table tbody:nth-of-type(1) td.sku"); // stepKey: seeProductSkuVerifyProductRowInOrder
		$I->waitForText("$13.00", 30, "#my-orders-table tbody:nth-of-type(1) td.price"); // stepKey: seeProductPriceVerifyProductRowInOrder
		$I->waitForText("1", 30, "#my-orders-table tbody:nth-of-type(1) td.qty"); // stepKey: seeProductQuantityVerifyProductRowInOrder
		$I->waitForText("$13.00", 30, "#my-orders-table tbody:nth-of-type(1) td.subtotal"); // stepKey: seeProductSubtotalVerifyProductRowInOrder
		$I->comment("Exiting Action Group [verifyProductRowInOrder] StorefrontVerifyCustomerOrderProductRowDataActionGroup");
		$I->waitForText("import_attribute1", 30, "#my-orders-table tbody:nth-of-type(1) td.name"); // stepKey: seeProductAttribute
		$I->waitForText("option3", 30, "#my-orders-table tbody:nth-of-type(1) td.name"); // stepKey: seeProductAttributeOption
		$I->comment("Import Configurable Product");
	}
}
