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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4930844: User filters images by the area they used in")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4930844")
 * @Description("User filters images by the area they used in<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminEnhancedMediaGalleryVerifyUsedInFilterTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminEnhancedMediaGalleryVerifyUsedInFilterTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [disableWYSIWYG] AdminDisableWYSIWYGActionGroup");
		$disableWYSIWYGDisableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled disabled", 60); // stepKey: disableWYSIWYGDisableWYSIWYG
		$I->comment($disableWYSIWYGDisableWYSIWYG);
		$I->comment("Exiting Action Group [disableWYSIWYG] AdminDisableWYSIWYGActionGroup");
		$I->comment("Entering Action Group [resetAdminDataGridToDefaultView] ResetAdminDataGridToDefaultViewActionGroup");
		$I->waitForElementVisible("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']", 30); // stepKey: waitForViewBookmarksResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: waitForViewBookmarksResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: selectDefaultGridViewResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: selectDefaultGridViewResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->see("Default View", "div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: seeDefaultViewSelectedResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: seeDefaultViewSelectedResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->comment("Exiting Action Group [resetAdminDataGridToDefaultView] ResetAdminDataGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [selectFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='wysiwyg']", 30); // stepKey: waitBeforeClickOnFolderSelectFolder
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='wysiwyg']"); // stepKey: selectFolderSelectFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectFolder
		$I->comment("Exiting Action Group [selectFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->comment("Entering Action Group [enableMassActionToDeleteImages] AdminEnhancedMediaGalleryEnableMassActionModeActionGroup");
		$I->wait(5); // stepKey: waitBeforeEnableMassActionToDeleteImages
		$I->waitForElementVisible("#delete_massaction", 30); // stepKey: waitForMassActionButtonEnableMassActionToDeleteImages
		$I->click("#delete_massaction"); // stepKey: clickOnMassActionButtonEnableMassActionToDeleteImages
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedEnableMassActionToDeleteImages
		$I->wait(5); // stepKey: waitAfterEnableMassActionToDeleteImages
		$I->comment("Exiting Action Group [enableMassActionToDeleteImages] AdminEnhancedMediaGalleryEnableMassActionModeActionGroup");
		$I->comment("Entering Action Group [selectFirstImageToDelete] AdminEnhancedMediaGallerySelectImageForMassActionActionGroup");
		$I->checkOption("//input[@type='checkbox'][@data-ui-id ='Title of the magento image']"); // stepKey: selectImageInGridToDelteSelectFirstImageToDelete
		$I->comment("Exiting Action Group [selectFirstImageToDelete] AdminEnhancedMediaGallerySelectImageForMassActionActionGroup");
		$I->comment("Entering Action Group [selectSecondImageToDelete] AdminEnhancedMediaGallerySelectImageForMassActionActionGroup");
		$I->checkOption("//input[@type='checkbox'][@data-ui-id ='renamed title']"); // stepKey: selectImageInGridToDelteSelectSecondImageToDelete
		$I->comment("Exiting Action Group [selectSecondImageToDelete] AdminEnhancedMediaGallerySelectImageForMassActionActionGroup");
		$I->comment("Entering Action Group [clikDeleteSelectedButton] AdminEnhancedMediaGalleryClickDeleteImagesButtonActionGroup");
		$I->click("#delete_selected_massaction"); // stepKey: clickDeleteImagesClikDeleteSelectedButton
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeleteModalClikDeleteSelectedButton
		$I->comment("Exiting Action Group [clikDeleteSelectedButton] AdminEnhancedMediaGalleryClickDeleteImagesButtonActionGroup");
		$I->comment("Entering Action Group [deleteImage] AdminEnhancedMediaGalleryConfirmDeleteImagesActionGroup");
		$I->click(".media-gallery-delete-image-action .action-accept"); // stepKey: confirmDeleteDeleteImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeletingProccesDeleteImage
		$I->comment("Exiting Action Group [deleteImage] AdminEnhancedMediaGalleryConfirmDeleteImagesActionGroup");
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"User filters images by the area they used in"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEnhancedMediaGalleryVerifyUsedInFilterTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [openCategory] AdminCategoriesOpenCategoryActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('category', 'name', 'test') . "')]"); // stepKey: clickCategoryLinkOpenCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkOpenCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategory
		$I->comment("Exiting Action Group [openCategory] AdminCategoriesOpenCategoryActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryFromWysiwyg] AdminOpenMediaGalleryTinyMceActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: clickExpandContentOpenMediaGalleryFromWysiwyg
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCEOpenMediaGalleryFromWysiwyg
		$I->click("button[title='Insert/edit image']"); // stepKey: clickInsertImageIconOpenMediaGalleryFromWysiwyg
		$I->waitForPageLoad(30); // stepKey: clickInsertImageIconOpenMediaGalleryFromWysiwygWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryFromWysiwyg
		$I->click(".tox-browse-url"); // stepKey: clickBrowseOpenMediaGalleryFromWysiwyg
		$I->waitForPageLoad(30); // stepKey: waitForPopupOpenMediaGalleryFromWysiwyg
		$I->comment("Exiting Action Group [openMediaGalleryFromWysiwyg] AdminOpenMediaGalleryTinyMceActionGroup");
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
		$I->comment("Entering Action Group [saveCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveCategory
		$I->comment("Exiting Action Group [saveCategory] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryFromWysiwygToFilterIMage] AdminOpenMediaGalleryTinyMceActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: clickExpandContentOpenMediaGalleryFromWysiwygToFilterIMage
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCEOpenMediaGalleryFromWysiwygToFilterIMage
		$I->click("button[title='Insert/edit image']"); // stepKey: clickInsertImageIconOpenMediaGalleryFromWysiwygToFilterIMage
		$I->waitForPageLoad(30); // stepKey: clickInsertImageIconOpenMediaGalleryFromWysiwygToFilterIMageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryFromWysiwygToFilterIMage
		$I->click(".tox-browse-url"); // stepKey: clickBrowseOpenMediaGalleryFromWysiwygToFilterIMage
		$I->waitForPageLoad(30); // stepKey: waitForPopupOpenMediaGalleryFromWysiwygToFilterIMage
		$I->comment("Exiting Action Group [openMediaGalleryFromWysiwygToFilterIMage] AdminOpenMediaGalleryTinyMceActionGroup");
		$I->comment("Entering Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-expand']"); // stepKey: expandFilterExpandFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearExpandFilters
		$I->comment("Exiting Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->comment("Entering Action Group [applyUsedInCategoryFilter] AdminMediaGalleryApplyUsedInFilterActionGroup");
		$I->click("//label[@class='admin__form-field-label']/span[text()='Show Images Used In']/parent::*/parent::div/div//div[@class='admin__action-multiselect-text' and text()='Select...']"); // stepKey: openUsedInfilterApplyUsedInCategoryFilter
		$I->click("//label[@class='admin__action-multiselect-label']/span[text()='Categories']"); // stepKey: selectEntityTypeApplyUsedInCategoryFilter
		$I->click("//div[label/span[contains(text(), 'Show Images Used In')]]//button[@data-action='close-advanced-select']"); // stepKey: clickDoneApplyUsedInCategoryFilter
		$I->comment("Exiting Action Group [applyUsedInCategoryFilter] AdminMediaGalleryApplyUsedInFilterActionGroup");
		$I->comment("Entering Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearApplyFilters
		$I->comment("Exiting Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->comment("Entering Action Group [assertImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
		$I->waitForElementVisible("//li[@data-ui-id='title'and text()='Title of the magento image']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']", 30); // stepKey: waitForImageToBeVisibleAssertImageInGrid
		$I->comment("Exiting Action Group [assertImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
		$I->comment("Entering Action Group [assertImageNotExistsInGrid] AdminMediaGalleryAssertImageNotExistsInTheGridActionGroup");
		$I->dontSeeElement("//li[@data-ui-id='title'and text()='renamed title']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']"); // stepKey: waitForImageToBeVisibleAssertImageNotExistsInGrid
		$I->comment("Exiting Action Group [assertImageNotExistsInGrid] AdminMediaGalleryAssertImageNotExistsInTheGridActionGroup");
	}
}
