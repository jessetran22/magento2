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
 * @Title("MC-38408: Import Grouped Product")
 * @Description("Imports a .csv file containing a grouped product. Verifies that product is imported             successfully and can be purchased.<h3>Test files</h3>app/code/Magento/GroupedImportExport/Test/Mftf/Test/AdminImportGroupedProductTest.xml<br>")
 * @TestCaseId("MC-38408")
 * @group importExport
 * @group GroupedProduct
 */
class AdminImportGroupedProductTestCest
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
		$I->comment("Create Category & Customer");
		$I->createEntity("createImportCategory", "hook", "ImportCategory_Grouped", [], []); // stepKey: createImportCategory
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Copy Images to Import Directory for Product Images");
		$I->comment('[createDirectoryForImportImages] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::createDirectory()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->createDirectory("var/import/images/import-product-grouped", 511); // stepKey: createDirectoryForImportImages
		$I->comment('[copyProduct1BaseImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/magento-logo.png", "var/import/images/import-product-grouped/magento-logo.png"); // stepKey: copyProduct1BaseImage
		$I->comment('[copyProduct2BaseImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/m-logo.gif", "var/import/images/import-product-grouped/m-logo.gif"); // stepKey: copyProduct2BaseImage
		$I->comment('[copyProduct3BaseImage] Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions::copy()');
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->copy("dev/tests/acceptance/tests/_data/adobe-base.jpg", "var/import/images/import-product-grouped/adobe-base.jpg"); // stepKey: copyProduct3BaseImage
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
		$this->helperContainer->get('Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions')->deleteDirectory("var/import/images/import-product-grouped"); // stepKey: deleteProductImageDirectory
		$I->deleteEntityByUrl("/V1/products/import-product-simple1-grouped"); // stepKey: deleteImportedSimpleProduct1
		$I->deleteEntityByUrl("/V1/products/import-product-simple2-grouped"); // stepKey: deleteImportedSimpleProduct2
		$I->deleteEntityByUrl("/V1/products/import-product-simple3-grouped"); // stepKey: deleteImportedSimpleProduct3
		$I->deleteEntityByUrl("/V1/products/import-product-grouped"); // stepKey: deleteImportedGroupedProduct
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
	 * @Features({"GroupedImportExport"})
	 * @Stories({"Import Products"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminImportGroupedProductTest(AcceptanceTester $I)
	{
		$I->comment("Import Grouped Product & Assert No Errors");
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
		$I->attachFile("#import_file", "import_grouped_product.csv"); // stepKey: attachFileForImportFillImportForm
		$I->fillField("#import_images_file_dir", "import-product-grouped"); // stepKey: fillImagesFileDirectoryFieldFillImportForm
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
		$I->see("import_grouped_product.csv", "table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: seeImportedFile
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
		$I->fillField("input.admin__control-text[name='sku']", "import-product-simple1-grouped"); // stepKey: fillProductSkuFilterGoToSimpleProduct1EditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToSimpleProduct1EditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToSimpleProduct1EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToSimpleProduct1EditPage
		$I->click("//td/div[text()='import-product-simple1-grouped']"); // stepKey: clickProductGoToSimpleProduct1EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToSimpleProduct1EditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToSimpleProduct1EditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-simple1-grouped"); // stepKey: seeProductSKUGoToSimpleProduct1EditPage
		$I->comment("Exiting Action Group [goToSimpleProduct1EditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct1OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertSimpleProduct1OnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertSimpleProduct1OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertSimpleProduct1OnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-simple1-grouped"); // stepKey: seeProductNameAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-simple1-grouped"); // stepKey: seeProductSkuAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "11.00"); // stepKey: seeProductPriceAssertSimpleProduct1OnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "101"); // stepKey: seeProductQuantityAssertSimpleProduct1OnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertSimpleProduct1OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertSimpleProduct1OnEditPageWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", "1"); // stepKey: seeProductWeightAssertSimpleProduct1OnEditPage
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeProductVisibilityAssertSimpleProduct1OnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-grouped')]"); // stepKey: seeProductCategoriesAssertSimpleProduct1OnEditPage
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
		$I->fillField("input.admin__control-text[name='sku']", "import-product-simple2-grouped"); // stepKey: fillProductSkuFilterGoToSimpleProduct2EditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToSimpleProduct2EditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToSimpleProduct2EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToSimpleProduct2EditPage
		$I->click("//td/div[text()='import-product-simple2-grouped']"); // stepKey: clickProductGoToSimpleProduct2EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToSimpleProduct2EditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToSimpleProduct2EditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-simple2-grouped"); // stepKey: seeProductSKUGoToSimpleProduct2EditPage
		$I->comment("Exiting Action Group [goToSimpleProduct2EditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct2OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertSimpleProduct2OnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertSimpleProduct2OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertSimpleProduct2OnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-simple2-grouped"); // stepKey: seeProductNameAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-simple2-grouped"); // stepKey: seeProductSkuAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "12.00"); // stepKey: seeProductPriceAssertSimpleProduct2OnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "102"); // stepKey: seeProductQuantityAssertSimpleProduct2OnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertSimpleProduct2OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertSimpleProduct2OnEditPageWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", "2"); // stepKey: seeProductWeightAssertSimpleProduct2OnEditPage
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeProductVisibilityAssertSimpleProduct2OnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-grouped')]"); // stepKey: seeProductCategoriesAssertSimpleProduct2OnEditPage
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
		$I->fillField("input.admin__control-text[name='sku']", "import-product-simple3-grouped"); // stepKey: fillProductSkuFilterGoToSimpleProduct3EditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToSimpleProduct3EditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToSimpleProduct3EditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToSimpleProduct3EditPage
		$I->click("//td/div[text()='import-product-simple3-grouped']"); // stepKey: clickProductGoToSimpleProduct3EditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToSimpleProduct3EditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToSimpleProduct3EditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-simple3-grouped"); // stepKey: seeProductSKUGoToSimpleProduct3EditPage
		$I->comment("Exiting Action Group [goToSimpleProduct3EditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct3OnEditPage] AdminAssertProductInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertSimpleProduct3OnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertSimpleProduct3OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertSimpleProduct3OnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-simple3-grouped"); // stepKey: seeProductNameAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-simple3-grouped"); // stepKey: seeProductSkuAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=price] input", "13.00"); // stepKey: seeProductPriceAssertSimpleProduct3OnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "103"); // stepKey: seeProductQuantityAssertSimpleProduct3OnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertSimpleProduct3OnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertSimpleProduct3OnEditPageWaitForPageLoad
		$I->seeInField(".admin__field[data-index=weight] input", "3"); // stepKey: seeProductWeightAssertSimpleProduct3OnEditPage
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeProductVisibilityAssertSimpleProduct3OnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-grouped')]"); // stepKey: seeProductCategoriesAssertSimpleProduct3OnEditPage
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
		$I->comment("Admin: Verify Grouped Product Common Data on Edit Product Page");
		$I->comment("Entering Action Group [goToGroupedProductEditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToAdminProductIndexPageGoToGroupedProductEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageToLoadGoToGroupedProductEditPage
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersGoToGroupedProductEditPage
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersGoToGroupedProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersGoToGroupedProductEditPage
		$I->dontSeeElement(".admin__data-grid-header button[data-action='grid-filter-reset']"); // stepKey: dontSeeClearFiltersGoToGroupedProductEditPage
		$I->waitForPageLoad(30); // stepKey: dontSeeClearFiltersGoToGroupedProductEditPageWaitForPageLoad
		$I->click(".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: openViewBookmarksTabGoToGroupedProductEditPage
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: resetToDefaultGridViewGoToGroupedProductEditPage
		$I->waitForPageLoad(30); // stepKey: resetToDefaultGridViewGoToGroupedProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForResetToDefaultViewGoToGroupedProductEditPage
		$I->see("Default View", ".admin__data-grid-action-bookmarks button.admin__action-dropdown"); // stepKey: seeDefaultViewSelectedGoToGroupedProductEditPage
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersGoToGroupedProductEditPage
		$I->fillField("input.admin__control-text[name='sku']", "import-product-grouped"); // stepKey: fillProductSkuFilterGoToGroupedProductEditPage
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersGoToGroupedProductEditPage
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersGoToGroupedProductEditPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFilterOnGridGoToGroupedProductEditPage
		$I->click("//td/div[text()='import-product-grouped']"); // stepKey: clickProductGoToGroupedProductEditPage
		$I->waitForPageLoad(30); // stepKey: waitForProductEditPageLoadGoToGroupedProductEditPage
		$I->waitForElementVisible("//*[@name='product[sku]']", 30); // stepKey: waitForProductSKUFieldGoToGroupedProductEditPage
		$I->seeInField("//*[@name='product[sku]']", "import-product-grouped"); // stepKey: seeProductSKUGoToGroupedProductEditPage
		$I->comment("Exiting Action Group [goToGroupedProductEditPage] NavigateToCreatedProductEditPageActionGroup");
		$I->comment("Entering Action Group [assertGroupedProductOnEditPage] AdminAssertGroupedProductGeneralInfoOnEditPageActionGroup");
		$I->waitForElementVisible("input[name='product[status]']", 30); // stepKey: waitForProductStatusAssertGroupedProductOnEditPage
		$I->seeElement("input[name='product[status]'][value='1']"); // stepKey: seeProductStatusAssertGroupedProductOnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStatusAssertGroupedProductOnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("div[data-index='attribute_set_id'] .admin__field-control", "Default"); // stepKey: seeProductAttributeSetAssertGroupedProductOnEditPage
		$I->seeInField(".admin__field[data-index=name] input", "import-product-grouped"); // stepKey: seeProductNameAssertGroupedProductOnEditPage
		$I->seeInField(".admin__field[data-index=sku] input", "import-product-grouped"); // stepKey: seeProductSkuAssertGroupedProductOnEditPage
		$I->seeInField(".admin__field[data-index=qty] input", "0"); // stepKey: seeProductQuantityAssertGroupedProductOnEditPage
		$I->seeInField("select[name='product[quantity_and_stock_status][is_in_stock]']", "In Stock"); // stepKey: seeProductStockStatusAssertGroupedProductOnEditPage
		$I->waitForPageLoad(30); // stepKey: seeProductStockStatusAssertGroupedProductOnEditPageWaitForPageLoad
		$I->seeOptionIsSelected("//select[@name='product[visibility]']", "Catalog, Search"); // stepKey: seeProductVisibilityAssertGroupedProductOnEditPage
		$I->seeElement("//*[@class='admin__action-multiselect-crumb']/span[contains(text(), 'import-category-grouped')]"); // stepKey: seeProductCategoriesAssertGroupedProductOnEditPage
		$I->comment("Exiting Action Group [assertGroupedProductOnEditPage] AdminAssertGroupedProductGeneralInfoOnEditPageActionGroup");
		$I->comment("Entering Action Group [assertGroupedProductBaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertGroupedProductBaseImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertGroupedProductBaseImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]", 30); // stepKey: seeImageAssertGroupedProductBaseImageOnEditPage
		$I->comment("Exiting Action Group [assertGroupedProductBaseImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'magento-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='image']"); // stepKey: seeBaseImageRoleGrouped
		$I->comment("Entering Action Group [assertGroupedProductSmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertGroupedProductSmallImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertGroupedProductSmallImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]", 30); // stepKey: seeImageAssertGroupedProductSmallImageOnEditPage
		$I->comment("Exiting Action Group [assertGroupedProductSmallImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'm-logo')]/ancestor::div[@data-role='image']//*[@data-role-code='small_image']"); // stepKey: seeSmallImageRoleGrouped
		$I->comment("Entering Action Group [assertGroupedProductThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->conditionalClick("div[data-index=gallery] .admin__collapsible-title", "div.image div.fileinput-button", false); // stepKey: openProductImagesSectionAssertGroupedProductThumbnailImageOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAssertGroupedProductThumbnailImageOnEditPage
		$I->waitForElementVisible("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]", 30); // stepKey: seeImageAssertGroupedProductThumbnailImageOnEditPage
		$I->comment("Exiting Action Group [assertGroupedProductThumbnailImageOnEditPage] AdminAssertProductImageOnProductPageActionGroup");
		$I->seeElement("//*[@id='media_gallery_content']//img[contains(@src, 'adobe-base')]/ancestor::div[@data-role='image']//*[@data-role-code='thumbnail']"); // stepKey: seeThumbnailImageRoleGrouped
		$I->comment("Admin: Verify Grouped Product Information on Edit Product Page");
		$I->seeNumberOfElements("[data-index=associated] .data-row", "3"); // stepKey: see3RowsAdmin
		$I->comment("Entering Action Group [verifyAssociatedProduct1Admin] AdminVerifyAssociatedProductForGroupedProductActionGroup");
		$I->waitForElementVisible("[data-index=associated] .data-row:nth-of-type(1) [data-index=thumbnail] img", 30); // stepKey: waitForProductImageVerifyAssociatedProduct1Admin
		$grabProductImageSrcVerifyAssociatedProduct1Admin = $I->grabAttributeFrom("[data-index=associated] .data-row:nth-of-type(1) [data-index=thumbnail] img", "src"); // stepKey: grabProductImageSrcVerifyAssociatedProduct1Admin
		$I->assertStringContainsString("m-logo", $grabProductImageSrcVerifyAssociatedProduct1Admin); // stepKey: assertProductImageSrcVerifyAssociatedProduct1Admin
		$I->see("import-product-simple2-grouped", "[data-index=associated] .data-row:nth-of-type(1) span[data-index=name]"); // stepKey: seeProductNameVerifyAssociatedProduct1Admin
		$I->see("Default", "[data-index=associated] .data-row:nth-of-type(1) span[data-index=attribute_set]"); // stepKey: seeProductAttributeSetVerifyAssociatedProduct1Admin
		$I->see("Enabled", "[data-index=associated] .data-row:nth-of-type(1) span[data-index=status]"); // stepKey: seeProductStatusVerifyAssociatedProduct1Admin
		$I->see("import-product-simple2-grouped", ".data-row td[data-index='sku']"); // stepKey: seeProductSkuVerifyAssociatedProduct1Admin
		$I->see("$12.00", "[data-index=associated] .data-row:nth-of-type(1) span[data-index=price]"); // stepKey: seeProductPriceVerifyAssociatedProduct1Admin
		$I->seeInField("[data-index=associated] .data-row:nth-of-type(1) [data-index=qty] input", "2"); // stepKey: seeProductDefaultQuantityVerifyAssociatedProduct1Admin
		$I->seeInField("[data-index=associated] .data-row:nth-of-type(1) .position-widget-input", "0"); // stepKey: seeProductPositionVerifyAssociatedProduct1Admin
		$I->comment("Exiting Action Group [verifyAssociatedProduct1Admin] AdminVerifyAssociatedProductForGroupedProductActionGroup");
		$I->comment("Entering Action Group [verifyAssociatedProduct2Admin] AdminVerifyAssociatedProductForGroupedProductActionGroup");
		$I->waitForElementVisible("[data-index=associated] .data-row:nth-of-type(2) [data-index=thumbnail] img", 30); // stepKey: waitForProductImageVerifyAssociatedProduct2Admin
		$grabProductImageSrcVerifyAssociatedProduct2Admin = $I->grabAttributeFrom("[data-index=associated] .data-row:nth-of-type(2) [data-index=thumbnail] img", "src"); // stepKey: grabProductImageSrcVerifyAssociatedProduct2Admin
		$I->assertStringContainsString("magento-logo", $grabProductImageSrcVerifyAssociatedProduct2Admin); // stepKey: assertProductImageSrcVerifyAssociatedProduct2Admin
		$I->see("import-product-simple1-grouped", "[data-index=associated] .data-row:nth-of-type(2) span[data-index=name]"); // stepKey: seeProductNameVerifyAssociatedProduct2Admin
		$I->see("Default", "[data-index=associated] .data-row:nth-of-type(2) span[data-index=attribute_set]"); // stepKey: seeProductAttributeSetVerifyAssociatedProduct2Admin
		$I->see("Enabled", "[data-index=associated] .data-row:nth-of-type(2) span[data-index=status]"); // stepKey: seeProductStatusVerifyAssociatedProduct2Admin
		$I->see("import-product-simple1-grouped", ".data-row td[data-index='sku']"); // stepKey: seeProductSkuVerifyAssociatedProduct2Admin
		$I->see("$11.00", "[data-index=associated] .data-row:nth-of-type(2) span[data-index=price]"); // stepKey: seeProductPriceVerifyAssociatedProduct2Admin
		$I->seeInField("[data-index=associated] .data-row:nth-of-type(2) [data-index=qty] input", "3"); // stepKey: seeProductDefaultQuantityVerifyAssociatedProduct2Admin
		$I->seeInField("[data-index=associated] .data-row:nth-of-type(2) .position-widget-input", "1"); // stepKey: seeProductPositionVerifyAssociatedProduct2Admin
		$I->comment("Exiting Action Group [verifyAssociatedProduct2Admin] AdminVerifyAssociatedProductForGroupedProductActionGroup");
		$I->comment("Entering Action Group [verifyAssociatedProduct3Admin] AdminVerifyAssociatedProductForGroupedProductActionGroup");
		$I->waitForElementVisible("[data-index=associated] .data-row:nth-of-type(3) [data-index=thumbnail] img", 30); // stepKey: waitForProductImageVerifyAssociatedProduct3Admin
		$grabProductImageSrcVerifyAssociatedProduct3Admin = $I->grabAttributeFrom("[data-index=associated] .data-row:nth-of-type(3) [data-index=thumbnail] img", "src"); // stepKey: grabProductImageSrcVerifyAssociatedProduct3Admin
		$I->assertStringContainsString("adobe-base", $grabProductImageSrcVerifyAssociatedProduct3Admin); // stepKey: assertProductImageSrcVerifyAssociatedProduct3Admin
		$I->see("import-product-simple3-grouped", "[data-index=associated] .data-row:nth-of-type(3) span[data-index=name]"); // stepKey: seeProductNameVerifyAssociatedProduct3Admin
		$I->see("Default", "[data-index=associated] .data-row:nth-of-type(3) span[data-index=attribute_set]"); // stepKey: seeProductAttributeSetVerifyAssociatedProduct3Admin
		$I->see("Enabled", "[data-index=associated] .data-row:nth-of-type(3) span[data-index=status]"); // stepKey: seeProductStatusVerifyAssociatedProduct3Admin
		$I->see("import-product-simple3-grouped", ".data-row td[data-index='sku']"); // stepKey: seeProductSkuVerifyAssociatedProduct3Admin
		$I->see("$13.00", "[data-index=associated] .data-row:nth-of-type(3) span[data-index=price]"); // stepKey: seeProductPriceVerifyAssociatedProduct3Admin
		$I->seeInField("[data-index=associated] .data-row:nth-of-type(3) [data-index=qty] input", "1"); // stepKey: seeProductDefaultQuantityVerifyAssociatedProduct3Admin
		$I->seeInField("[data-index=associated] .data-row:nth-of-type(3) .position-widget-input", "2"); // stepKey: seeProductPositionVerifyAssociatedProduct3Admin
		$I->comment("Exiting Action Group [verifyAssociatedProduct3Admin] AdminVerifyAssociatedProductForGroupedProductActionGroup");
		$I->comment("Storefront: Verify Grouped Product In Category");
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
		$I->amOnPage("/import-category-grouped.html"); // stepKey: goToStorefrontCategoryPageGoToCategoryPage
		$I->comment("Exiting Action Group [goToCategoryPage] StorefrontNavigateToCategoryUrlActionGroup");
		$I->seeNumberOfElements(".product-item-name", "4"); // stepKey: see4Products
		$I->see("import-product-simple1-grouped", "#maincontent .column.main"); // stepKey: seeSimpleProduct1
		$I->see("import-product-simple2-grouped", "#maincontent .column.main"); // stepKey: seeSimpleProduct2
		$I->see("import-product-simple3-grouped", "#maincontent .column.main"); // stepKey: seeSimpleProduct3
		$I->see("import-product-grouped", "#maincontent .column.main"); // stepKey: seeGroupedProduct
		$I->comment("Storefront: Verify Grouped Product Info & Images");
		$I->comment("Entering Action Group [openProductStorefrontPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/import-product-grouped.html"); // stepKey: openProductPageOpenProductStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductStorefrontPage
		$I->comment("Exiting Action Group [openProductStorefrontPage] StorefrontOpenProductPageActionGroup");
		$I->see("import-product-grouped", ".base"); // stepKey: seeProductName
		$I->see("import-product-grouped", ".product.attribute.sku>.value"); // stepKey: seeSku
		$I->seeElement("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'magento-logo')]"); // stepKey: seeProduct1BaseImage
		$I->seeElement("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'm-logo')]"); // stepKey: seeProduct2BaseImage
		$I->seeElement("//*[@id='maincontent']//div[@class='gallery-placeholder']//img[contains(@src, 'adobe-base')]"); // stepKey: seeProduct3BaseImage
		$I->comment("Storefront: Verify Associated Grouped Products");
		$I->seeNumberOfElements("#super-product-table tbody tr", "3"); // stepKey: see3RowsStorefront
		$I->comment("Entering Action Group [verifyAssociatedProduct1Storefront] StorefrontVerifyAssociatedProductForGroupedProductActionGroup");
		$I->waitForElementVisible("#super-product-table tbody tr", 30); // stepKey: waitForGroupedProductRowsVerifyAssociatedProduct1Storefront
		$I->see("import-product-simple2-grouped", "#super-product-table tbody tr:nth-of-type(1) .product-item-name"); // stepKey: seeProductNameVerifyAssociatedProduct1Storefront
		$I->see("$12.00", "#super-product-table tbody tr:nth-of-type(1) .price"); // stepKey: seeProductPriceVerifyAssociatedProduct1Storefront
		$I->seeInField("#super-product-table tbody tr:nth-of-type(1) input.qty", "2"); // stepKey: seeProductQuantityVerifyAssociatedProduct1Storefront
		$I->comment("Exiting Action Group [verifyAssociatedProduct1Storefront] StorefrontVerifyAssociatedProductForGroupedProductActionGroup");
		$I->comment("Entering Action Group [verifyAssociatedProduct2Storefront] StorefrontVerifyAssociatedProductForGroupedProductActionGroup");
		$I->waitForElementVisible("#super-product-table tbody tr", 30); // stepKey: waitForGroupedProductRowsVerifyAssociatedProduct2Storefront
		$I->see("import-product-simple1-grouped", "#super-product-table tbody tr:nth-of-type(2) .product-item-name"); // stepKey: seeProductNameVerifyAssociatedProduct2Storefront
		$I->see("$11.00", "#super-product-table tbody tr:nth-of-type(2) .price"); // stepKey: seeProductPriceVerifyAssociatedProduct2Storefront
		$I->seeInField("#super-product-table tbody tr:nth-of-type(2) input.qty", "3"); // stepKey: seeProductQuantityVerifyAssociatedProduct2Storefront
		$I->comment("Exiting Action Group [verifyAssociatedProduct2Storefront] StorefrontVerifyAssociatedProductForGroupedProductActionGroup");
		$I->comment("Entering Action Group [verifyAssociatedProduct3Storefront] StorefrontVerifyAssociatedProductForGroupedProductActionGroup");
		$I->waitForElementVisible("#super-product-table tbody tr", 30); // stepKey: waitForGroupedProductRowsVerifyAssociatedProduct3Storefront
		$I->see("import-product-simple3-grouped", "#super-product-table tbody tr:nth-of-type(3) .product-item-name"); // stepKey: seeProductNameVerifyAssociatedProduct3Storefront
		$I->see("$13.00", "#super-product-table tbody tr:nth-of-type(3) .price"); // stepKey: seeProductPriceVerifyAssociatedProduct3Storefront
		$I->seeInField("#super-product-table tbody tr:nth-of-type(3) input.qty", "1"); // stepKey: seeProductQuantityVerifyAssociatedProduct3Storefront
		$I->comment("Exiting Action Group [verifyAssociatedProduct3Storefront] StorefrontVerifyAssociatedProductForGroupedProductActionGroup");
		$I->comment("Purchase Grouped Product");
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
		$I->comment("Confirm Purchased Grouped Product");
		$I->comment("Entering Action Group [openOrderFromSuccessPage] StorefrontOpenOrderFromSuccessPageActionGroup");
		$I->click("//div[contains(@class,'success')]//a[contains(.,'{$grabOrderNumber}')]"); // stepKey: clickOrderNumberLinkOpenOrderFromSuccessPage
		$I->waitForPageLoad(30); // stepKey: clickOrderNumberLinkOpenOrderFromSuccessPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageIsLoadedOpenOrderFromSuccessPage
		$I->see("Order # {$grabOrderNumber}", ".page-title span"); // stepKey: assertOrderNumberIsCorrectOpenOrderFromSuccessPage
		$I->comment("Exiting Action Group [openOrderFromSuccessPage] StorefrontOpenOrderFromSuccessPageActionGroup");
		$simpleProduct1Subtotal = $I->executeJS("return (Math.round((11.00*3)*100)/100).toString()"); // stepKey: simpleProduct1Subtotal
		$simpleProduct2Subtotal = $I->executeJS("return (Math.round((12.00*2)*100)/100).toString()"); // stepKey: simpleProduct2Subtotal
		$simpleProduct3Subtotal = $I->executeJS("return (Math.round((13.00*1)*100)/100).toString()"); // stepKey: simpleProduct3Subtotal
		$I->comment("Entering Action Group [verifyProductRow1InOrder] StorefrontVerifyCustomerOrderProductRowDataActionGroup");
		$I->waitForText("import-product-simple2-grouped", 30, "#my-orders-table tbody:nth-of-type(1) td.name"); // stepKey: seeProductNameVerifyProductRow1InOrder
		$I->waitForText("import-product-simple2-grouped", 30, "#my-orders-table tbody:nth-of-type(1) td.sku"); // stepKey: seeProductSkuVerifyProductRow1InOrder
		$I->waitForText("$12.00", 30, "#my-orders-table tbody:nth-of-type(1) td.price"); // stepKey: seeProductPriceVerifyProductRow1InOrder
		$I->waitForText("2", 30, "#my-orders-table tbody:nth-of-type(1) td.qty"); // stepKey: seeProductQuantityVerifyProductRow1InOrder
		$I->waitForText($simpleProduct2Subtotal, 30, "#my-orders-table tbody:nth-of-type(1) td.subtotal"); // stepKey: seeProductSubtotalVerifyProductRow1InOrder
		$I->comment("Exiting Action Group [verifyProductRow1InOrder] StorefrontVerifyCustomerOrderProductRowDataActionGroup");
		$I->comment("Entering Action Group [verifyProductRow2InOrder] StorefrontVerifyCustomerOrderProductRowDataActionGroup");
		$I->waitForText("import-product-simple1-grouped", 30, "#my-orders-table tbody:nth-of-type(2) td.name"); // stepKey: seeProductNameVerifyProductRow2InOrder
		$I->waitForText("import-product-simple1-grouped", 30, "#my-orders-table tbody:nth-of-type(2) td.sku"); // stepKey: seeProductSkuVerifyProductRow2InOrder
		$I->waitForText("$11.00", 30, "#my-orders-table tbody:nth-of-type(2) td.price"); // stepKey: seeProductPriceVerifyProductRow2InOrder
		$I->waitForText("3", 30, "#my-orders-table tbody:nth-of-type(2) td.qty"); // stepKey: seeProductQuantityVerifyProductRow2InOrder
		$I->waitForText($simpleProduct1Subtotal, 30, "#my-orders-table tbody:nth-of-type(2) td.subtotal"); // stepKey: seeProductSubtotalVerifyProductRow2InOrder
		$I->comment("Exiting Action Group [verifyProductRow2InOrder] StorefrontVerifyCustomerOrderProductRowDataActionGroup");
		$I->comment("Entering Action Group [verifyProductRow3InOrder] StorefrontVerifyCustomerOrderProductRowDataActionGroup");
		$I->waitForText("import-product-simple3-grouped", 30, "#my-orders-table tbody:nth-of-type(3) td.name"); // stepKey: seeProductNameVerifyProductRow3InOrder
		$I->waitForText("import-product-simple3-grouped", 30, "#my-orders-table tbody:nth-of-type(3) td.sku"); // stepKey: seeProductSkuVerifyProductRow3InOrder
		$I->waitForText("$13.00", 30, "#my-orders-table tbody:nth-of-type(3) td.price"); // stepKey: seeProductPriceVerifyProductRow3InOrder
		$I->waitForText("1", 30, "#my-orders-table tbody:nth-of-type(3) td.qty"); // stepKey: seeProductQuantityVerifyProductRow3InOrder
		$I->waitForText($simpleProduct3Subtotal, 30, "#my-orders-table tbody:nth-of-type(3) td.subtotal"); // stepKey: seeProductSubtotalVerifyProductRow3InOrder
		$I->comment("Exiting Action Group [verifyProductRow3InOrder] StorefrontVerifyCustomerOrderProductRowDataActionGroup");
	}
}
