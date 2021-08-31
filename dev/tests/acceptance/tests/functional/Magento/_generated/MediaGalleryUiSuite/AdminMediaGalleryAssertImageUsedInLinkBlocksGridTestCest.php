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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4951848: Used in blocks link")
 * @Description("User filters assets used in blocks<h3>Test files</h3>app/code/Magento/MediaGalleryCmsUi/Test/Mftf/Test/AdminMediaGalleryAssertImageUsedInLinkBlocksGridTest.xml<br>")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4951848")
 * @group media_gallery_ui
 */
class AdminMediaGalleryAssertImageUsedInLinkBlocksGridTestCest
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
		$I->createEntity("createBlock", "hook", "_defaultBlock", [], []); // stepKey: createBlock
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
		$I->deleteEntity("createBlock", "hook"); // stepKey: deleteBlock
		$I->comment("Entering Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGallery
		$I->comment("Exiting Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [clearFiltersOnStandaloneMediaGalleryPage] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFiltersOnStandaloneMediaGalleryPage
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersOnStandaloneMediaGalleryPageWaitForPageLoad
		$I->comment("Exiting Action Group [clearFiltersOnStandaloneMediaGalleryPage] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [selectCreatedFolderAgain] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitBeforeClickOnFolderSelectCreatedFolderAgain
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']"); // stepKey: selectFolderSelectCreatedFolderAgain
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectCreatedFolderAgain
		$I->comment("Exiting Action Group [selectCreatedFolderAgain] AdminMediaGalleryFolderSelectActionGroup");
		$I->comment("Entering Action Group [openViewImageDetailsToVerifyEmptyUsedIn] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuOpenViewImageDetailsToVerifyEmptyUsedIn
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsOpenViewImageDetailsToVerifyEmptyUsedIn
		$I->waitForPageLoad(30); // stepKey: viewDetailsOpenViewImageDetailsToVerifyEmptyUsedInWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearOpenViewImageDetailsToVerifyEmptyUsedIn
		$I->comment("Exiting Action Group [openViewImageDetailsToVerifyEmptyUsedIn] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [assertThereIsNoUsedInSection] AssertAdminEnhancedMediaGalleryUsedInSectionNotDisplayedActionGroup");
		$I->dontSeeElement("//div[@class='attribute']/span[contains(text(), 'Used In')]"); // stepKey: assertImageIsDeletedAssertThereIsNoUsedInSection
		$I->comment("Exiting Action Group [assertThereIsNoUsedInSection] AssertAdminEnhancedMediaGalleryUsedInSectionNotDisplayedActionGroup");
		$I->comment("Entering Action Group [closeImageDetails] AdminEnhancedMediaGalleryCloseViewDetailsActionGroup");
		$I->click("#image-details-action-cancel"); // stepKey: clickCancelCloseImageDetails
		$I->waitForPageLoad(10); // stepKey: clickCancelCloseImageDetailsWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForElementRenderCloseImageDetails
		$I->comment("Exiting Action Group [closeImageDetails] AdminEnhancedMediaGalleryCloseViewDetailsActionGroup");
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
		$I->comment("Entering Action Group [clearFiltersOnMediaGalleryPage] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFiltersOnMediaGalleryPage
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersOnMediaGalleryPageWaitForPageLoad
		$I->comment("Exiting Action Group [clearFiltersOnMediaGalleryPage] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [deleteAllImagesAfterTest] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: openMediaGalleryPageDeleteAllImagesAfterTest
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllImagesAfterTest
		$I->conditionalClick("//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllImagesAfterTest
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllImagesAfterTestWaitForPageLoad
		$I->comment('[deleteAllImagesUsingMassActionDeleteAllImagesAfterTest] Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper::deleteAllImagesUsingMassAction()');
		$this->helperContainer->get('Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper')->deleteAllImagesUsingMassAction("[data-id='media-gallery-masonry-grid'] .no-data-message-container", "#delete_massaction", "[data-id='media-gallery-masonry-grid'] .mediagallery-massaction-checkbox input[type='checkbox']", "#delete_selected_massaction", ".media-gallery-delete-image-action .action-accept", ".media-gallery-container ul.messages div.message.message-success span", "been successfully deleted"); // stepKey: deleteAllImagesUsingMassActionDeleteAllImagesAfterTest
		$I->comment("Exiting Action Group [deleteAllImagesAfterTest] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
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
	 * @Features({"MediaGalleryCmsUi"})
	 * @Stories({"Story 58: User sees entities where asset is used in"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryAssertImageUsedInLinkBlocksGridTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCreatedCMSBlockPage] NavigateToCreatedCMSBlockPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCreatedCMSBlockPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSBlockPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSBlockPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSBlockPage
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSBlockPage
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSBlockPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//button[text()='Select']"); // stepKey: clickSelectCreatedCMSBlockNavigateToCreatedCMSBlockPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//a[text()='Edit']"); // stepKey: navigateToCreatedCMSBlockNavigateToCreatedCMSBlockPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSBlockPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSBlockPage
		$I->comment("Exiting Action Group [navigateToCreatedCMSBlockPage] NavigateToCreatedCMSBlockPageActionGroup");
		$I->click(".scalable.action-add-image.plugin"); // stepKey: clickInsertImageIcon
		$I->waitForPageLoad(30); // stepKey: waitForInitialPageLoad
		$I->waitForElementVisible("#create_folder", 30); // stepKey: waitForNewFolderButton
		$I->comment("Entering Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilter] ClearFiltersAdminDataGridActionGroup");
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
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadAfterNewFolderCreated
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
		$I->click("#save-button"); // stepKey: saveBlock
		$I->waitForPageLoad(10); // stepKey: saveBlockWaitForPageLoad
		$I->comment("Entering Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGallery
		$I->comment("Exiting Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [clearFiltersOnStandaloneMediaGallery] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFiltersOnStandaloneMediaGallery
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersOnStandaloneMediaGalleryWaitForPageLoad
		$I->comment("Exiting Action Group [clearFiltersOnStandaloneMediaGallery] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [selectCreatedFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitBeforeClickOnFolderSelectCreatedFolder
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']"); // stepKey: selectFolderSelectCreatedFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectCreatedFolder
		$I->comment("Exiting Action Group [selectCreatedFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->comment("Entering Action Group [openViewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuOpenViewImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsOpenViewImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsOpenViewImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearOpenViewImageDetails
		$I->comment("Exiting Action Group [openViewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [clickUsedInBlocks] AdminEnhancedMediaGalleryClickEntityUsedInActionGroup");
		$I->click("//div[@class='attribute']/span[contains(text(), 'Used In')]/following-sibling::div/a[contains(text(), 'Blocks')]"); // stepKey: openContextMenuClickUsedInBlocks
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickUsedInBlocks
		$I->comment("Exiting Action Group [clickUsedInBlocks] AdminEnhancedMediaGalleryClickEntityUsedInActionGroup");
		$I->comment("Entering Action Group [assertFilterApplied] AdminAssertMediaGalleryFilterPlaceHolderGridActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitVisibleFilterAssertFilterApplied
		$I->waitForElementVisible(".admin__data-grid-header .admin__data-grid-filters-current._show", 30); // stepKey: waitForRequestAssertFilterApplied
		$I->see("Title of the magento image", ".admin__data-grid-header .admin__data-grid-filters-current._show"); // stepKey: seeFilterAssertFilterApplied
		$I->comment("Exiting Action Group [assertFilterApplied] AdminAssertMediaGalleryFilterPlaceHolderGridActionGroup");
		$I->comment("Entering Action Group [clearFilterInBlocksGrid] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilterInBlocksGrid
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFilterInBlocksGridWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilterInBlocksGrid] ClearFiltersAdminDataGridActionGroup");
	}
}
