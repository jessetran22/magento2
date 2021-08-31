<?php
namespace Magento\AcceptanceTest\_MediaGalleryUiSuite\Backend;

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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4951024: User sees entities where asset is used in")
 * @Description("User sees entities where asset is used in<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminEnhancedMediaGalleryVerifyFilterByAssetTest.xml<br>")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4951024")
 * @group media_gallery_ui
 */
class AdminEnhancedMediaGalleryVerifyFilterByAssetTestCest
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
        $this->helperContainer->create("Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
		$I->comment("Entering Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$enableWYSIWYGEnableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled enabled", 60); // stepKey: enableWYSIWYGEnableWYSIWYG
		$I->comment($enableWYSIWYGEnableWYSIWYG);
		$I->comment("Exiting Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteAllImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: openMediaGalleryPageDeleteAllImages
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllImages
		$I->conditionalClick("//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllImages
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllImagesWaitForPageLoad
		$I->comment('[deleteAllImagesUsingMassActionDeleteAllImages] Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper::deleteAllImagesUsingMassAction()');
		$this->helperContainer->get('Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper')->deleteAllImagesUsingMassAction("[data-id='media-gallery-masonry-grid'] .no-data-message-container", "#delete_massaction", "[data-id='media-gallery-masonry-grid'] .mediagallery-massaction-checkbox input[type='checkbox']", "#delete_selected_massaction", ".media-gallery-delete-image-action .action-accept", ".media-gallery-container ul.messages div.message.message-success span", "been successfully deleted"); // stepKey: deleteAllImagesUsingMassActionDeleteAllImages
		$I->comment("Exiting Action Group [deleteAllImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$disableWYSIWYGDisableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled disabled", 60); // stepKey: disableWYSIWYGDisableWYSIWYG
		$I->comment($disableWYSIWYGDisableWYSIWYG);
		$I->comment("Exiting Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$I->comment("Entering Action Group [deleteAllImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: openMediaGalleryPageDeleteAllImages
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllImages
		$I->conditionalClick("//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllImages
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllImagesWaitForPageLoad
		$I->comment('[deleteAllImagesUsingMassActionDeleteAllImages] Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper::deleteAllImagesUsingMassAction()');
		$this->helperContainer->get('Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper')->deleteAllImagesUsingMassAction("[data-id='media-gallery-masonry-grid'] .no-data-message-container", "#delete_massaction", "[data-id='media-gallery-masonry-grid'] .mediagallery-massaction-checkbox input[type='checkbox']", "#delete_selected_massaction", ".media-gallery-delete-image-action .action-accept", ".media-gallery-container ul.messages div.message.message-success span", "been successfully deleted"); // stepKey: deleteAllImagesUsingMassActionDeleteAllImages
		$I->comment("Exiting Action Group [deleteAllImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryCategoryGridPage] AdminOpenCategoryGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery_catalog/category/index"); // stepKey: navigateToCategoryGridPageOpenMediaGalleryCategoryGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryCategoryGridPage
		$I->comment("Exiting Action Group [openMediaGalleryCategoryGridPage] AdminOpenCategoryGridPageActionGroup");
		$I->comment("Entering Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
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
	 * @Features({"MediaGalleryUi"})
	 * @Stories({"Story 58: User sees entities where asset is used in"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEnhancedMediaGalleryVerifyFilterByAssetTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCategoryPage] GoToAdminCategoryPageByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/edit/id/" . $I->retrieveEntityField('category', 'id', 'test') . "/"); // stepKey: amOnAdminCategoryPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCategoryPage
		$I->see($I->retrieveEntityField('category', 'id', 'test'), ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] GoToAdminCategoryPageByIdActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryFromWysiwyg] AdminOpenMediaGalleryTinyMceActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: clickExpandContentOpenMediaGalleryFromWysiwyg
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCEOpenMediaGalleryFromWysiwyg
		$I->click("button[title='Insert/edit image']"); // stepKey: clickInsertImageIconOpenMediaGalleryFromWysiwyg
		$I->waitForPageLoad(30); // stepKey: clickInsertImageIconOpenMediaGalleryFromWysiwygWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryFromWysiwyg
		$I->click(".tox-browse-url"); // stepKey: clickBrowseOpenMediaGalleryFromWysiwyg
		$I->waitForPageLoad(30); // stepKey: waitForPopupOpenMediaGalleryFromWysiwyg
		$I->comment("Exiting Action Group [openMediaGalleryFromWysiwyg] AdminOpenMediaGalleryTinyMceActionGroup");
		$I->comment("Entering Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [uploadFirstIMage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadFirstIMage
		$I->attachFile("#image-uploader-input", "magento3.jpg"); // stepKey: uploadImageUploadFirstIMage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadFirstIMage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadFirstIMage
		$I->comment("Exiting Action Group [uploadFirstIMage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [uploadSecondImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadSecondImage
		$I->attachFile("#image-uploader-input", "magento-again.jpg"); // stepKey: uploadImageUploadSecondImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadSecondImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadSecondImage
		$I->comment("Exiting Action Group [uploadSecondImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [selectCategoryImageInGrid] AdminMediaGalleryClickImageInGridActionGroup");
		$I->waitForElementVisible("//li[@data-ui-id='title'and text()='Title of the magento image']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']", 30); // stepKey: waitForImageToBeVisibleSelectCategoryImageInGrid
		$I->click("//li[@data-ui-id='title'and text()='Title of the magento image']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']"); // stepKey: clickOnImageSelectCategoryImageInGrid
		$I->comment("Exiting Action Group [selectCategoryImageInGrid] AdminMediaGalleryClickImageInGridActionGroup");
		$I->comment("Entering Action Group [clickAddSelectedContentImage] AdminMediaGalleryClickAddSelectedActionGroup");
		$I->waitForElementVisible(".media-gallery-add-selected", 30); // stepKey: waitForAddSelectedButtonClickAddSelectedContentImage
		$I->click(".media-gallery-add-selected"); // stepKey: ClickAddSelectedClickAddSelectedContentImage
		$I->waitForPageLoad(30); // stepKey: waitForImageToBeAddedClickAddSelectedContentImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappearClickAddSelectedContentImage
		$I->comment("Exiting Action Group [clickAddSelectedContentImage] AdminMediaGalleryClickAddSelectedActionGroup");
		$I->comment("Entering Action Group [clickOkButton] AdminMediaGalleryClickOkButtonTinyMceActionGroup");
		$I->waitForElementVisible(".tox-dialog__footer button[title='Save']", 30); // stepKey: waitForOkBtnClickOkButton
		$I->click(".tox-dialog__footer button[title='Save']"); // stepKey: clickOkBtnClickOkButton
		$I->waitForPageLoad(30); // stepKey: waitClickOkButton
		$I->comment("Exiting Action Group [clickOkButton] AdminMediaGalleryClickOkButtonTinyMceActionGroup");
		$I->comment("Entering Action Group [saveCategory] AdminSaveCategoryFormActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageSaveCategory
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfTheCategoryPageSaveCategory
		$I->click("#save"); // stepKey: saveCategorySaveCategory
		$I->waitForPageLoad(30); // stepKey: saveCategorySaveCategoryWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveCategory
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCategory
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: assertSuccessMessageSaveCategory
		$I->comment("Exiting Action Group [saveCategory] AdminSaveCategoryFormActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryCategoryGridPage] AdminOpenCategoryGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery_catalog/category/index"); // stepKey: navigateToCategoryGridPageOpenMediaGalleryCategoryGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryCategoryGridPage
		$I->comment("Exiting Action Group [openMediaGalleryCategoryGridPage] AdminOpenCategoryGridPageActionGroup");
		$I->comment("Entering Action Group [clearGridFiltersAgain] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFiltersAgain
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFiltersAgainWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFiltersAgain] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [expandFilters] AdminEnhancedMediaGalleryCategoryGridExpandFilterActionGroup");
		$I->click("//div[@class='media-gallery-category-container']//button[@data-action='grid-filter-expand']"); // stepKey: expandFilterExpandFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearExpandFilters
		$I->comment("Exiting Action Group [expandFilters] AdminEnhancedMediaGalleryCategoryGridExpandFilterActionGroup");
		$I->comment("Entering Action Group [setUsedInFilter] AdminEnhancedMediaGallerySelectUsedInFilterActionGroup");
		$I->click("//div[label/span[contains(text(), 'Asset')]]//div[@class='action-select admin__action-multiselect']"); // stepKey: openFilterSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: openFilterSetUsedInFilterWaitForPageLoad
		$I->fillField("//div[label/span[contains(text(), 'Asset')]]//input[@data-role='advanced-select-text']", "Title of the magento image"); // stepKey: enterOptionNameSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: enterOptionNameSetUsedInFilterWaitForPageLoad
		$I->click("//div[label/span[contains(text(), 'Asset')]]//label[@class='admin__action-multiselect-label']/span[text()='Title of the magento image']"); // stepKey: selectOptionSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: selectOptionSetUsedInFilterWaitForPageLoad
		$I->click("//div[label/span[contains(text(), 'Asset')]]//button[@data-action='close-advanced-select']"); // stepKey: clickDoneSetUsedInFilter
		$I->comment("Exiting Action Group [setUsedInFilter] AdminEnhancedMediaGallerySelectUsedInFilterActionGroup");
		$I->comment("Entering Action Group [applyFilters] AdminEnhancedMediaGalleryCategoryGridApplyFiltersActionGroup");
		$I->click("//div[@class='media-gallery-category-container']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearApplyFilters
		$I->comment("Exiting Action Group [applyFilters] AdminEnhancedMediaGalleryCategoryGridApplyFiltersActionGroup");
		$I->comment("Entering Action Group [assertOneRecordInGrid] AssertAdminCategoryGridPageNumberOfRecordsActionGroup");
		$grabNumberOfRecordsFoundAssertOneRecordInGrid = $I->grabTextFrom(".admin__data-grid-header .admin__control-support-text"); // stepKey: grabNumberOfRecordsFoundAssertOneRecordInGrid
		$I->assertEquals("1 records found", $grabNumberOfRecordsFoundAssertOneRecordInGrid); // stepKey: assertStringIsEqualAssertOneRecordInGrid
		$I->comment("Exiting Action Group [assertOneRecordInGrid] AssertAdminCategoryGridPageNumberOfRecordsActionGroup");
		$I->comment("Entering Action Group [assertCategoryGridPageImageColumn] AssertAdminCategoryGridPageImageColumnActionGroup");
		$getImageSrcAssertCategoryGridPageImageColumn = $I->grabAttributeFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Image')]/preceding-sibling::th) +1]//img", "src"); // stepKey: getImageSrcAssertCategoryGridPageImageColumn
		$I->assertStringContainsString("magento", $getImageSrcAssertCategoryGridPageImageColumn); // stepKey: assertImageSrcAssertCategoryGridPageImageColumn
		$I->comment("Exiting Action Group [assertCategoryGridPageImageColumn] AssertAdminCategoryGridPageImageColumnActionGroup");
		$I->comment("Entering Action Group [assertCategoryInGrid] AssertAdminCategoryGridPageDetailsActionGroup");
		$grabNameColumnValueAssertCategoryInGrid = $I->grabTextFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Name')]/preceding-sibling::th) +1 ]//div"); // stepKey: grabNameColumnValueAssertCategoryInGrid
		$I->assertEquals($I->retrieveEntityField('category', 'name', 'test'), $grabNameColumnValueAssertCategoryInGrid); // stepKey: assertNameColumnAssertCategoryInGrid
		$grabPathColumnValueAssertCategoryInGrid = $I->grabTextFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Path')]/preceding-sibling::th) +1 ]//div"); // stepKey: grabPathColumnValueAssertCategoryInGrid
		$I->assertStringContainsString($I->retrieveEntityField('category', 'name', 'test'), $grabPathColumnValueAssertCategoryInGrid); // stepKey: assertPathColumnAssertCategoryInGrid
		$I->comment("Exiting Action Group [assertCategoryInGrid] AssertAdminCategoryGridPageDetailsActionGroup");
		$I->comment("Entering Action Group [assertCategoryGridPageProductsInMenuEnabledColumns] AssertAdminCategoryGridPageProductsInMenuEnabledColumnsActionGroup");
		$grabProductsColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns = $I->grabTextFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Products')]/preceding-sibling::th) +1 ]//div"); // stepKey: grabProductsColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns
		$I->assertEquals("0", $grabProductsColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns); // stepKey: assertProductsColumnAssertCategoryGridPageProductsInMenuEnabledColumns
		$grabInMenuColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns = $I->grabTextFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'In Menu')]/preceding-sibling::th) +1 ]//div"); // stepKey: grabInMenuColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns
		$I->assertEquals("Yes", $grabInMenuColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns); // stepKey: assertInMenuColumnAssertCategoryGridPageProductsInMenuEnabledColumns
		$grabEnabledColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns = $I->grabTextFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Enabled')]/preceding-sibling::th) +1 ]//div"); // stepKey: grabEnabledColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns
		$I->assertEquals("Yes", $grabEnabledColumnValueAssertCategoryGridPageProductsInMenuEnabledColumns); // stepKey: assertEnabledColumnAssertCategoryGridPageProductsInMenuEnabledColumns
		$I->comment("Exiting Action Group [assertCategoryGridPageProductsInMenuEnabledColumns] AssertAdminCategoryGridPageProductsInMenuEnabledColumnsActionGroup");
	}
}
