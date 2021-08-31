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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/943908/scenarios/4523889: User can open each entity the asset is associated with in a separate tab to manage association")
 * @Description("User can open each entity the asset is associated with in a separate tab to manage association<h3>Test files</h3>app/code/Magento/MediaGalleryCatalogUi/Test/Mftf/Test/AdminMediaGalleryCatalogUiVerifyUsedInLinkedCategoryGridTest.xml<br>")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/943908/scenarios/4523889")
 * @group media_gallery_ui
 */
class AdminMediaGalleryCatalogUiVerifyUsedInLinkedCategoryGridTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteAllMediaGalleryImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: openMediaGalleryPageDeleteAllMediaGalleryImages
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllMediaGalleryImages
		$I->conditionalClick("//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllMediaGalleryImages
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllMediaGalleryImagesWaitForPageLoad
		$I->comment('[deleteAllImagesUsingMassActionDeleteAllMediaGalleryImages] Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper::deleteAllImagesUsingMassAction()');
		$this->helperContainer->get('Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper')->deleteAllImagesUsingMassAction("[data-id='media-gallery-masonry-grid'] .no-data-message-container", "#delete_massaction", "[data-id='media-gallery-masonry-grid'] .mediagallery-massaction-checkbox input[type='checkbox']", "#delete_selected_massaction", ".media-gallery-delete-image-action .action-accept", ".media-gallery-container ul.messages div.message.message-success span", "been successfully deleted"); // stepKey: deleteAllImagesUsingMassActionDeleteAllMediaGalleryImages
		$I->comment("Exiting Action Group [deleteAllMediaGalleryImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryCategoryGridPage] AdminOpenCategoryGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery_catalog/category/index"); // stepKey: navigateToCategoryGridPageOpenMediaGalleryCategoryGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryCategoryGridPage
		$I->comment("Exiting Action Group [openMediaGalleryCategoryGridPage] AdminOpenCategoryGridPageActionGroup");
		$I->comment("Entering Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGallery
		$I->comment("Exiting Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [resetMediaGalleryGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetMediaGalleryGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetMediaGalleryGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [resetMediaGalleryGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [selectFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitBeforeClickOnFolderSelectFolder
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']"); // stepKey: selectFolderSelectFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectFolder
		$I->comment("Exiting Action Group [selectFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->comment("Entering Action Group [deleteFolder] AdminMediaGalleryFolderDeleteActionGroup");
		$I->waitForElementVisible("#delete_folder:not(.disabled)", 30); // stepKey: waitBeforeDeleteButtonWillBeActiveDeleteFolder
		$I->waitForPageLoad(30); // stepKey: waitBeforeDeleteButtonWillBeActiveDeleteFolderWaitForPageLoad
		$I->click("#delete_folder:not(.disabled)"); // stepKey: clickDeleteButtonDeleteFolder
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonDeleteFolderWaitForPageLoad
		$I->waitForElementVisible("//h1[contains(text(), 'Are you sure you want to delete this folder?')]", 30); // stepKey: waitBeforeModalAppearsDeleteFolder
		$I->click("//footer//button/span[contains(text(), 'OK')]"); // stepKey: clickConfirmDeleteButtonDeleteFolder
		$I->waitForPageLoad(30); // stepKey: clickConfirmDeleteButtonDeleteFolderWaitForPageLoad
		$I->comment("Exiting Action Group [deleteFolder] AdminMediaGalleryFolderDeleteActionGroup");
		$I->comment("Entering Action Group [assertFolderWasDeleted] AdminMediaGalleryAssertFolderDoesNotExistActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForFolderTreeReloadsAssertFolderWasDeleted
		$I->dontSeeElement("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']"); // stepKey: folderDoesNotExistAssertFolderWasDeleted
		$I->comment("Exiting Action Group [assertFolderWasDeleted] AdminMediaGalleryAssertFolderDoesNotExistActionGroup");
		$I->comment("Entering Action Group [deleteAllMediaGalleryImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: openMediaGalleryPageDeleteAllMediaGalleryImages
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllMediaGalleryImages
		$I->conditionalClick("//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllMediaGalleryImages
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllMediaGalleryImagesWaitForPageLoad
		$I->comment('[deleteAllImagesUsingMassActionDeleteAllMediaGalleryImages] Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper::deleteAllImagesUsingMassAction()');
		$this->helperContainer->get('Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper')->deleteAllImagesUsingMassAction("[data-id='media-gallery-masonry-grid'] .no-data-message-container", "#delete_massaction", "[data-id='media-gallery-masonry-grid'] .mediagallery-massaction-checkbox input[type='checkbox']", "#delete_selected_massaction", ".media-gallery-delete-image-action .action-accept", ".media-gallery-container ul.messages div.message.message-success span", "been successfully deleted"); // stepKey: deleteAllImagesUsingMassActionDeleteAllMediaGalleryImages
		$I->comment("Exiting Action Group [deleteAllMediaGalleryImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
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
	 * @Features({"MediaGalleryCatalogUi"})
	 * @Stories({"Story 58: User sees entities where asset is used in"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryCatalogUiVerifyUsedInLinkedCategoryGridTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCategoryPage] GoToAdminCategoryPageByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/edit/id/" . $I->retrieveEntityField('category', 'id', 'test') . "/"); // stepKey: amOnAdminCategoryPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCategoryPage
		$I->see($I->retrieveEntityField('category', 'id', 'test'), ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] GoToAdminCategoryPageByIdActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryFromImageUploader] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Select from Gallery']", false); // stepKey: clickExpandContentOpenMediaGalleryFromImageUploader
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Select from Gallery']", 30); // stepKey: waitForSelectFromGalleryOpenMediaGalleryFromImageUploader
		$I->click("//*[@class='file-uploader-area']/label[text()='Select from Gallery']"); // stepKey: clickSelectFromGalleryOpenMediaGalleryFromImageUploader
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryFromImageUploader
		$I->comment("Exiting Action Group [openMediaGalleryFromImageUploader] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear
		$I->comment("Entering Action Group [resetMediaGalleryGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetMediaGalleryGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetMediaGalleryGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [resetMediaGalleryGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [openNewFolderForm] AdminMediaGalleryOpenNewFolderFormActionGroup");
		$I->click("#create_folder"); // stepKey: clickCreateNewFolderButtonOpenNewFolderForm
		$I->waitForElementVisible("//h1[contains(text(), 'New Folder Name')]", 30); // stepKey: waitForModalOpenOpenNewFolderForm
		$I->comment("Exiting Action Group [openNewFolderForm] AdminMediaGalleryOpenNewFolderFormActionGroup");
		$I->comment("Entering Action Group [createNewFolder] AdminMediaGalleryCreateNewFolderActionGroup");
		$I->fillField("[name=folder_name]", "folder" . msq("AdminMediaGalleryFolderData")); // stepKey: setFolderNameCreateNewFolder
		$I->click("//button/span[contains(text(),'Confirm')]"); // stepKey: clickCreateButtonCreateNewFolder
		$I->waitForPageLoad(30); // stepKey: clickCreateButtonCreateNewFolderWaitForPageLoad
		$I->comment("Exiting Action Group [createNewFolder] AdminMediaGalleryCreateNewFolderActionGroup");
		$I->comment("Entering Action Group [assertNewFolderCreated] AdminMediaGalleryAssertFolderNameActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitForFolderAssertNewFolderCreated
		$I->comment("Exiting Action Group [assertNewFolderCreated] AdminMediaGalleryAssertFolderNameActionGroup");
		$I->comment("Entering Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadImage
		$I->attachFile("#image-uploader-input", "magento.jpg"); // stepKey: uploadImageUploadImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadImage
		$I->comment("Exiting Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [viewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuViewImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsViewImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsViewImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearViewImageDetails
		$I->comment("Exiting Action Group [viewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [editImage] AdminEnhancedMediaGalleryImageDetailsEditActionGroup");
		$I->click("//div[@class='media-gallery-image-details-modal']//button[contains(@class, 'edit')]"); // stepKey: editImageEditImage
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-edit-image-details') and contains(@class, '_show')]//h1[contains(., 'Edit Image')]", 30); // stepKey: waitForLoadingMaskToDisappearEditImage
		$I->comment("Exiting Action Group [editImage] AdminEnhancedMediaGalleryImageDetailsEditActionGroup");
		$I->comment("Entering Action Group [saveImage] AdminEnhancedMediaGalleryImageDetailsSaveActionGroup");
		$I->fillField("#title", "renamed title"); // stepKey: setTitleSaveImage
		$I->fillField("#description", "test description"); // stepKey: setDescriptionSaveImage
		$I->click("#image-details-action-save"); // stepKey: saveDetailsSaveImage
		$I->waitForPageLoad(30); // stepKey: saveDetailsSaveImageWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearSaveImage
		$I->comment("Exiting Action Group [saveImage] AdminEnhancedMediaGalleryImageDetailsSaveActionGroup");
		$I->comment("Entering Action Group [closeViewDetails] AdminEnhancedMediaGalleryCloseViewDetailsActionGroup");
		$I->click("#image-details-action-cancel"); // stepKey: clickCancelCloseViewDetails
		$I->waitForPageLoad(10); // stepKey: clickCancelCloseViewDetailsWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForElementRenderCloseViewDetails
		$I->comment("Exiting Action Group [closeViewDetails] AdminEnhancedMediaGalleryCloseViewDetailsActionGroup");
		$I->comment("Entering Action Group [clickAddSelectedCategoryImage] AdminMediaGalleryClickAddSelectedActionGroup");
		$I->waitForElementVisible(".media-gallery-add-selected", 30); // stepKey: waitForAddSelectedButtonClickAddSelectedCategoryImage
		$I->click(".media-gallery-add-selected"); // stepKey: ClickAddSelectedClickAddSelectedCategoryImage
		$I->waitForPageLoad(30); // stepKey: waitForImageToBeAddedClickAddSelectedCategoryImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappearClickAddSelectedCategoryImage
		$I->comment("Exiting Action Group [clickAddSelectedCategoryImage] AdminMediaGalleryClickAddSelectedActionGroup");
		$I->comment("Entering Action Group [saveCategory] AdminSaveCategoryFormActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageSaveCategory
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfTheCategoryPageSaveCategory
		$I->click("#save"); // stepKey: saveCategorySaveCategory
		$I->waitForPageLoad(30); // stepKey: saveCategorySaveCategoryWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveCategory
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCategory
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: assertSuccessMessageSaveCategory
		$I->comment("Exiting Action Group [saveCategory] AdminSaveCategoryFormActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryFromImageUploaderToVerifyLink] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Select from Gallery']", false); // stepKey: clickExpandContentOpenMediaGalleryFromImageUploaderToVerifyLink
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Select from Gallery']", 30); // stepKey: waitForSelectFromGalleryOpenMediaGalleryFromImageUploaderToVerifyLink
		$I->click("//*[@class='file-uploader-area']/label[text()='Select from Gallery']"); // stepKey: clickSelectFromGalleryOpenMediaGalleryFromImageUploaderToVerifyLink
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryFromImageUploaderToVerifyLink
		$I->comment("Exiting Action Group [openMediaGalleryFromImageUploaderToVerifyLink] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->comment("Entering Action Group [selectCategoryImageFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitBeforeClickOnFolderSelectCategoryImageFolder
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']"); // stepKey: selectFolderSelectCategoryImageFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectCategoryImageFolder
		$I->comment("Exiting Action Group [selectCategoryImageFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->comment("Entering Action Group [openViewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuOpenViewImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsOpenViewImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsOpenViewImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearOpenViewImageDetails
		$I->comment("Exiting Action Group [openViewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [clickUsedInCategories] AdminEnhancedMediaGalleryClickEntityUsedInActionGroup");
		$I->click("//div[@class='attribute']/span[contains(text(), 'Used In')]/following-sibling::div/a[contains(text(), 'Categories')]"); // stepKey: openContextMenuClickUsedInCategories
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickUsedInCategories
		$I->comment("Exiting Action Group [clickUsedInCategories] AdminEnhancedMediaGalleryClickEntityUsedInActionGroup");
		$I->comment("Entering Action Group [assertFilterApplied] AssertAdminMediaGalleryAssetFilterPlaceHolderActionGroup");
		$I->seeElement("//div[@class='admin__current-filters-list-wrap']//li//span[contains(text(), 'renamed title')]"); // stepKey: assertFilterPLaceHolderAssertFilterApplied
		$I->comment("Exiting Action Group [assertFilterApplied] AssertAdminMediaGalleryAssetFilterPlaceHolderActionGroup");
		$I->comment("Entering Action Group [assertOneRecordInGrid] AssertAdminCategoryGridPageNumberOfRecordsActionGroup");
		$grabNumberOfRecordsFoundAssertOneRecordInGrid = $I->grabTextFrom(".admin__data-grid-header .admin__control-support-text"); // stepKey: grabNumberOfRecordsFoundAssertOneRecordInGrid
		$I->assertEquals("1 records found", $grabNumberOfRecordsFoundAssertOneRecordInGrid); // stepKey: assertStringIsEqualAssertOneRecordInGrid
		$I->comment("Exiting Action Group [assertOneRecordInGrid] AssertAdminCategoryGridPageNumberOfRecordsActionGroup");
		$I->comment("Entering Action Group [assertCategoryGridPageImageColumn] AssertAdminCategoryGridPageImageColumnActionGroup");
		$getImageSrcAssertCategoryGridPageImageColumn = $I->grabAttributeFrom("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Image')]/preceding-sibling::th) +1]//img", "src"); // stepKey: getImageSrcAssertCategoryGridPageImageColumn
		$I->assertStringContainsString("magento.jpg", $getImageSrcAssertCategoryGridPageImageColumn); // stepKey: assertImageSrcAssertCategoryGridPageImageColumn
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
		$I->comment("Entering Action Group [resetCategoriesGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetCategoriesGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetCategoriesGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [resetCategoriesGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [expandFilters] AdminEnhancedMediaGalleryCategoryGridExpandFilterActionGroup");
		$I->click("//div[@class='media-gallery-category-container']//button[@data-action='grid-filter-expand']"); // stepKey: expandFilterExpandFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearExpandFilters
		$I->comment("Exiting Action Group [expandFilters] AdminEnhancedMediaGalleryCategoryGridExpandFilterActionGroup");
		$I->comment("Entering Action Group [setAssetFilter] AdminEnhancedMediaGallerySelectUsedInFilterActionGroup");
		$I->click("//div[label/span[contains(text(), 'Asset')]]//div[@class='action-select admin__action-multiselect']"); // stepKey: openFilterSetAssetFilter
		$I->waitForPageLoad(30); // stepKey: openFilterSetAssetFilterWaitForPageLoad
		$I->fillField("//div[label/span[contains(text(), 'Asset')]]//input[@data-role='advanced-select-text']", "renamed title"); // stepKey: enterOptionNameSetAssetFilter
		$I->waitForPageLoad(30); // stepKey: enterOptionNameSetAssetFilterWaitForPageLoad
		$I->click("//div[label/span[contains(text(), 'Asset')]]//label[@class='admin__action-multiselect-label']/span[text()='renamed title']"); // stepKey: selectOptionSetAssetFilter
		$I->waitForPageLoad(30); // stepKey: selectOptionSetAssetFilterWaitForPageLoad
		$I->click("//div[label/span[contains(text(), 'Asset')]]//button[@data-action='close-advanced-select']"); // stepKey: clickDoneSetAssetFilter
		$I->comment("Exiting Action Group [setAssetFilter] AdminEnhancedMediaGallerySelectUsedInFilterActionGroup");
		$I->comment("Entering Action Group [applyFilters] AdminEnhancedMediaGalleryCategoryGridApplyFiltersActionGroup");
		$I->click("//div[@class='media-gallery-category-container']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearApplyFilters
		$I->comment("Exiting Action Group [applyFilters] AdminEnhancedMediaGalleryCategoryGridApplyFiltersActionGroup");
		$I->comment("Entering Action Group [assertFilterAppliedAfterUrlFilterApplier] AssertAdminMediaGalleryAssetFilterPlaceHolderActionGroup");
		$I->seeElement("//div[@class='admin__current-filters-list-wrap']//li//span[contains(text(), 'renamed title')]"); // stepKey: assertFilterPLaceHolderAssertFilterAppliedAfterUrlFilterApplier
		$I->comment("Exiting Action Group [assertFilterAppliedAfterUrlFilterApplier] AssertAdminMediaGalleryAssetFilterPlaceHolderActionGroup");
		$I->deleteEntity("category", "test"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGallery
		$I->comment("Exiting Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [openCategoryImageFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitBeforeClickOnFolderOpenCategoryImageFolder
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']"); // stepKey: selectFolderOpenCategoryImageFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsOpenCategoryImageFolder
		$I->comment("Exiting Action Group [openCategoryImageFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->comment("Entering Action Group [openViewImageDetailsToVerifyEmptyUsedIn] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuOpenViewImageDetailsToVerifyEmptyUsedIn
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsOpenViewImageDetailsToVerifyEmptyUsedIn
		$I->waitForPageLoad(30); // stepKey: viewDetailsOpenViewImageDetailsToVerifyEmptyUsedInWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearOpenViewImageDetailsToVerifyEmptyUsedIn
		$I->comment("Exiting Action Group [openViewImageDetailsToVerifyEmptyUsedIn] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [assertThereIsNoUsedInSection] AssertAdminEnhancedMediaGalleryUsedInSectionNotDisplayedActionGroup");
		$I->dontSeeElement("//div[@class='attribute']/span[contains(text(), 'Used In')]"); // stepKey: assertImageIsDeletedAssertThereIsNoUsedInSection
		$I->comment("Exiting Action Group [assertThereIsNoUsedInSection] AssertAdminEnhancedMediaGalleryUsedInSectionNotDisplayedActionGroup");
		$I->comment("Entering Action Group [closeDetails] AdminEnhancedMediaGalleryCloseViewDetailsActionGroup");
		$I->click("#image-details-action-cancel"); // stepKey: clickCancelCloseDetails
		$I->waitForPageLoad(10); // stepKey: clickCancelCloseDetailsWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForElementRenderCloseDetails
		$I->comment("Exiting Action Group [closeDetails] AdminEnhancedMediaGalleryCloseViewDetailsActionGroup");
	}
}
