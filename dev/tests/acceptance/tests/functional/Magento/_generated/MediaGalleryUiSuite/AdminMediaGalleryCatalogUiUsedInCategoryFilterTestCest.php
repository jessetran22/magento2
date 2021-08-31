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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4951846: Used in categories filter")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4951846")
 * @Description("User filters assets used in categories<h3>Test files</h3>app/code/Magento/MediaGalleryCatalogUi/Test/Mftf/Test/AdminMediaGalleryCatalogUiUsedInCategoryFilterTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryCatalogUiUsedInCategoryFilterTestCest
{
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [enableMassActionToDeleteImages] AdminEnhancedMediaGalleryEnableMassActionModeActionGroup");
		$I->wait(5); // stepKey: waitBeforeEnableMassActionToDeleteImages
		$I->waitForElementVisible("#delete_massaction", 30); // stepKey: waitForMassActionButtonEnableMassActionToDeleteImages
		$I->click("#delete_massaction"); // stepKey: clickOnMassActionButtonEnableMassActionToDeleteImages
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedEnableMassActionToDeleteImages
		$I->wait(5); // stepKey: waitAfterEnableMassActionToDeleteImages
		$I->comment("Exiting Action Group [enableMassActionToDeleteImages] AdminEnhancedMediaGalleryEnableMassActionModeActionGroup");
		$I->comment("Entering Action Group [selectSecondImageToDelete] AdminEnhancedMediaGallerySelectImageForMassActionActionGroup");
		$I->checkOption("//input[@type='checkbox'][@data-ui-id ='renamed title']"); // stepKey: selectImageInGridToDelteSelectSecondImageToDelete
		$I->comment("Exiting Action Group [selectSecondImageToDelete] AdminEnhancedMediaGallerySelectImageForMassActionActionGroup");
		$I->comment("Entering Action Group [clickDeleteSelectedButton] AdminEnhancedMediaGalleryClickDeleteImagesButtonActionGroup");
		$I->click("#delete_selected_massaction"); // stepKey: clickDeleteImagesClickDeleteSelectedButton
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeleteModalClickDeleteSelectedButton
		$I->comment("Exiting Action Group [clickDeleteSelectedButton] AdminEnhancedMediaGalleryClickDeleteImagesButtonActionGroup");
		$I->comment("Entering Action Group [deleteImages] AdminEnhancedMediaGalleryConfirmDeleteImagesActionGroup");
		$I->click(".media-gallery-delete-image-action .action-accept"); // stepKey: confirmDeleteDeleteImages
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeletingProccesDeleteImages
		$I->comment("Exiting Action Group [deleteImages] AdminEnhancedMediaGalleryConfirmDeleteImagesActionGroup");
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
	 * @Features({"MediaGalleryCatalogUi"})
	 * @Stories({"Story 58: User sees entities where asset is used in"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryCatalogUiUsedInCategoryFilterTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [openMediaGalleryFromImageUploader] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Select from Gallery']", false); // stepKey: clickExpandContentOpenMediaGalleryFromImageUploader
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Select from Gallery']", 30); // stepKey: waitForSelectFromGalleryOpenMediaGalleryFromImageUploader
		$I->click("//*[@class='file-uploader-area']/label[text()='Select from Gallery']"); // stepKey: clickSelectFromGalleryOpenMediaGalleryFromImageUploader
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryFromImageUploader
		$I->comment("Exiting Action Group [openMediaGalleryFromImageUploader] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [resetGridToDefaultView] ResetAdminDataGridToDefaultViewActionGroup");
		$I->waitForElementVisible("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']", 30); // stepKey: waitForViewBookmarksResetGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: waitForViewBookmarksResetGridToDefaultViewWaitForPageLoad
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksResetGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksResetGridToDefaultViewWaitForPageLoad
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: selectDefaultGridViewResetGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: selectDefaultGridViewResetGridToDefaultViewWaitForPageLoad
		$I->see("Default View", "div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: seeDefaultViewSelectedResetGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: seeDefaultViewSelectedResetGridToDefaultViewWaitForPageLoad
		$I->comment("Exiting Action Group [resetGridToDefaultView] ResetAdminDataGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadImage
		$I->attachFile("#image-uploader-input", "magento3.jpg"); // stepKey: uploadImageUploadImage
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
		$I->comment("Entering Action Group [clickAddSelectedContentImage] AdminMediaGalleryClickAddSelectedActionGroup");
		$I->waitForElementVisible(".media-gallery-add-selected", 30); // stepKey: waitForAddSelectedButtonClickAddSelectedContentImage
		$I->click(".media-gallery-add-selected"); // stepKey: ClickAddSelectedClickAddSelectedContentImage
		$I->waitForPageLoad(30); // stepKey: waitForImageToBeAddedClickAddSelectedContentImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappearClickAddSelectedContentImage
		$I->comment("Exiting Action Group [clickAddSelectedContentImage] AdminMediaGalleryClickAddSelectedActionGroup");
		$I->comment("Entering Action Group [saveCategoryForm] AdminSaveCategoryFormActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageSaveCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfTheCategoryPageSaveCategoryForm
		$I->click("#save"); // stepKey: saveCategorySaveCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategorySaveCategoryFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveCategoryForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCategoryForm
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: assertSuccessMessageSaveCategoryForm
		$I->comment("Exiting Action Group [saveCategoryForm] AdminSaveCategoryFormActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryFromImageUploaderAgain] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Select from Gallery']", false); // stepKey: clickExpandContentOpenMediaGalleryFromImageUploaderAgain
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Select from Gallery']", 30); // stepKey: waitForSelectFromGalleryOpenMediaGalleryFromImageUploaderAgain
		$I->click("//*[@class='file-uploader-area']/label[text()='Select from Gallery']"); // stepKey: clickSelectFromGalleryOpenMediaGalleryFromImageUploaderAgain
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryFromImageUploaderAgain
		$I->comment("Exiting Action Group [openMediaGalleryFromImageUploaderAgain] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->comment("Entering Action Group [clearFilterAgain] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilterAgain
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterAgainWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilterAgain] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [resetGridToDefaultViewAgain] ResetAdminDataGridToDefaultViewActionGroup");
		$I->waitForElementVisible("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']", 30); // stepKey: waitForViewBookmarksResetGridToDefaultViewAgain
		$I->waitForPageLoad(30); // stepKey: waitForViewBookmarksResetGridToDefaultViewAgainWaitForPageLoad
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksResetGridToDefaultViewAgain
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksResetGridToDefaultViewAgainWaitForPageLoad
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: selectDefaultGridViewResetGridToDefaultViewAgain
		$I->waitForPageLoad(30); // stepKey: selectDefaultGridViewResetGridToDefaultViewAgainWaitForPageLoad
		$I->see("Default View", "div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: seeDefaultViewSelectedResetGridToDefaultViewAgain
		$I->waitForPageLoad(30); // stepKey: seeDefaultViewSelectedResetGridToDefaultViewAgainWaitForPageLoad
		$I->comment("Exiting Action Group [resetGridToDefaultViewAgain] ResetAdminDataGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-expand']"); // stepKey: expandFilterExpandFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearExpandFilters
		$I->comment("Exiting Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->comment("Entering Action Group [setUsedInFilter] AdminEnhancedMediaGallerySelectUsedInFilterActionGroup");
		$I->click("//div[label/span[contains(text(), 'Used in Categories')]]//div[@class='action-select admin__action-multiselect']"); // stepKey: openFilterSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: openFilterSetUsedInFilterWaitForPageLoad
		$I->fillField("//div[label/span[contains(text(), 'Used in Categories')]]//input[@data-role='advanced-select-text']", $I->retrieveEntityField('category', 'name', 'test')); // stepKey: enterOptionNameSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: enterOptionNameSetUsedInFilterWaitForPageLoad
		$I->click("//div[label/span[contains(text(), 'Used in Categories')]]//label[@class='admin__action-multiselect-label']/span[text()='" . $I->retrieveEntityField('category', 'name', 'test') . "']"); // stepKey: selectOptionSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: selectOptionSetUsedInFilterWaitForPageLoad
		$I->click("//div[label/span[contains(text(), 'Used in Categories')]]//button[@data-action='close-advanced-select']"); // stepKey: clickDoneSetUsedInFilter
		$I->comment("Exiting Action Group [setUsedInFilter] AdminEnhancedMediaGallerySelectUsedInFilterActionGroup");
		$I->comment("Entering Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearApplyFilters
		$I->comment("Exiting Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->comment("Entering Action Group [assertImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
		$I->waitForElementVisible("//li[@data-ui-id='title'and text()='renamed title']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']", 30); // stepKey: waitForImageToBeVisibleAssertImageInGrid
		$I->comment("Exiting Action Group [assertImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
	}
}
