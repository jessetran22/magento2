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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/943908/scenarios/4523889: User can open the product entity the asset is associated")
 * @Description("User filters assets used in products<h3>Test files</h3>app/code/Magento/MediaGalleryCatalogUi/Test/Mftf/Test/AdminMediaGalleryCatalogUiUsedInProductFilterOnTest.xml<br>")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/943908/scenarios/4523889")
 * @group media_gallery_ui
 */
class AdminMediaGalleryCatalogUiUsedInProductFilterOnTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$enableWYSIWYGEnableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled enabled", 60); // stepKey: enableWYSIWYGEnableWYSIWYG
		$I->comment($enableWYSIWYGEnableWYSIWYG);
		$I->comment("Exiting Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
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
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGallery
		$I->comment("Exiting Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [openViewImageDetailsToAssertEmptyUsedIn] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuOpenViewImageDetailsToAssertEmptyUsedIn
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsOpenViewImageDetailsToAssertEmptyUsedIn
		$I->waitForPageLoad(30); // stepKey: viewDetailsOpenViewImageDetailsToAssertEmptyUsedInWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearOpenViewImageDetailsToAssertEmptyUsedIn
		$I->comment("Exiting Action Group [openViewImageDetailsToAssertEmptyUsedIn] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [assertThereIsNoUsedInSection] AssertAdminEnhancedMediaGalleryUsedInSectionNotDisplayedActionGroup");
		$I->dontSeeElement("//div[@class='attribute']/span[contains(text(), 'Used In')]"); // stepKey: assertImageIsDeletedAssertThereIsNoUsedInSection
		$I->comment("Exiting Action Group [assertThereIsNoUsedInSection] AssertAdminEnhancedMediaGalleryUsedInSectionNotDisplayedActionGroup");
		$I->comment("Entering Action Group [closeDetails] AdminEnhancedMediaGalleryCloseViewDetailsActionGroup");
		$I->click("#image-details-action-cancel"); // stepKey: clickCancelCloseDetails
		$I->waitForPageLoad(10); // stepKey: clickCancelCloseDetailsWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForElementRenderCloseDetails
		$I->comment("Exiting Action Group [closeDetails] AdminEnhancedMediaGalleryCloseViewDetailsActionGroup");
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
		$I->comment("Entering Action Group [clickDeleteSelectedButton] AdminEnhancedMediaGalleryClickDeleteImagesButtonActionGroup");
		$I->click("#delete_selected_massaction"); // stepKey: clickDeleteImagesClickDeleteSelectedButton
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeleteModalClickDeleteSelectedButton
		$I->comment("Exiting Action Group [clickDeleteSelectedButton] AdminEnhancedMediaGalleryClickDeleteImagesButtonActionGroup");
		$I->comment("Entering Action Group [deleteImages] AdminEnhancedMediaGalleryConfirmDeleteImagesActionGroup");
		$I->click(".media-gallery-delete-image-action .action-accept"); // stepKey: confirmDeleteDeleteImages
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeletingProccesDeleteImages
		$I->comment("Exiting Action Group [deleteImages] AdminEnhancedMediaGalleryConfirmDeleteImagesActionGroup");
		$I->comment("Entering Action Group [clearFiltersAfterDeleteImages] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFiltersAfterDeleteImages
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersAfterDeleteImagesWaitForPageLoad
		$I->comment("Exiting Action Group [clearFiltersAfterDeleteImages] ClearFiltersAdminDataGridActionGroup");
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
	 * @Stories({"Story 58 - User sees entities where asset is used in"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryCatalogUiUsedInProductFilterOnTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createProduct', 'id', 'test')); // stepKey: goToProductGoToProductEditPage
		$I->comment("Exiting Action Group [goToProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryFromWysiwyg] AdminOpenMediaGalleryTinyMceActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: clickExpandContentOpenMediaGalleryFromWysiwyg
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCEOpenMediaGalleryFromWysiwyg
		$I->click("button[title='Insert/edit image']"); // stepKey: clickInsertImageIconOpenMediaGalleryFromWysiwyg
		$I->waitForPageLoad(30); // stepKey: clickInsertImageIconOpenMediaGalleryFromWysiwygWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryFromWysiwyg
		$I->click(".tox-browse-url"); // stepKey: clickBrowseOpenMediaGalleryFromWysiwyg
		$I->waitForPageLoad(30); // stepKey: waitForPopupOpenMediaGalleryFromWysiwyg
		$I->comment("Exiting Action Group [openMediaGalleryFromWysiwyg] AdminOpenMediaGalleryTinyMceActionGroup");
		$I->comment("Entering Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadImage
		$I->attachFile("#image-uploader-input", "magento3.jpg"); // stepKey: uploadImageUploadImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadImage
		$I->comment("Exiting Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [selectContentImageInGrid] AdminMediaGalleryClickImageInGridActionGroup");
		$I->waitForElementVisible("//li[@data-ui-id='title'and text()='Title of the magento image']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']", 30); // stepKey: waitForImageToBeVisibleSelectContentImageInGrid
		$I->click("//li[@data-ui-id='title'and text()='Title of the magento image']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']"); // stepKey: clickOnImageSelectContentImageInGrid
		$I->comment("Exiting Action Group [selectContentImageInGrid] AdminMediaGalleryClickImageInGridActionGroup");
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
		$I->comment("Entering Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGallery
		$I->comment("Exiting Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-expand']"); // stepKey: expandFilterExpandFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearExpandFilters
		$I->comment("Exiting Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->comment("Entering Action Group [setUsedInFilter] AdminEnhancedMediaGallerySelectUsedInFilterActionGroup");
		$I->click("//div[label/span[contains(text(), 'Used in Products')]]//div[@class='action-select admin__action-multiselect']"); // stepKey: openFilterSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: openFilterSetUsedInFilterWaitForPageLoad
		$I->fillField("//div[label/span[contains(text(), 'Used in Products')]]//input[@data-role='advanced-select-text']", $I->retrieveEntityField('createProduct', 'name', 'test')); // stepKey: enterOptionNameSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: enterOptionNameSetUsedInFilterWaitForPageLoad
		$I->click("//div[label/span[contains(text(), 'Used in Products')]]//label[@class='admin__action-multiselect-label']/span[text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']"); // stepKey: selectOptionSetUsedInFilter
		$I->waitForPageLoad(30); // stepKey: selectOptionSetUsedInFilterWaitForPageLoad
		$I->click("//div[label/span[contains(text(), 'Used in Products')]]//button[@data-action='close-advanced-select']"); // stepKey: clickDoneSetUsedInFilter
		$I->comment("Exiting Action Group [setUsedInFilter] AdminEnhancedMediaGallerySelectUsedInFilterActionGroup");
		$I->comment("Entering Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearApplyFilters
		$I->comment("Exiting Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->comment("Entering Action Group [openViewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuOpenViewImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsOpenViewImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsOpenViewImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearOpenViewImageDetails
		$I->comment("Exiting Action Group [openViewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [clickUsedInProducts] AdminEnhancedMediaGalleryClickEntityUsedInActionGroup");
		$I->click("//div[@class='attribute']/span[contains(text(), 'Used In')]/following-sibling::div/a[contains(text(), 'Products')]"); // stepKey: openContextMenuClickUsedInProducts
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickUsedInProducts
		$I->comment("Exiting Action Group [clickUsedInProducts] AdminEnhancedMediaGalleryClickEntityUsedInActionGroup");
		$I->comment("Entering Action Group [assertFilterApplied] AdminAssertMediaGalleryFilterPlaceHolderGridActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitVisibleFilterAssertFilterApplied
		$I->waitForElementVisible(".admin__data-grid-header .admin__data-grid-filters-current._show", 30); // stepKey: waitForRequestAssertFilterApplied
		$I->see("Title of the magento image", ".admin__data-grid-header .admin__data-grid-filters-current._show"); // stepKey: seeFilterAssertFilterApplied
		$I->comment("Exiting Action Group [assertFilterApplied] AdminAssertMediaGalleryFilterPlaceHolderGridActionGroup");
		$I->comment("Entering Action Group [clearFiltersOnProductGrid] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFiltersOnProductGrid
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersOnProductGridWaitForPageLoad
		$I->comment("Exiting Action Group [clearFiltersOnProductGrid] ClearFiltersAdminDataGridActionGroup");
	}
}
