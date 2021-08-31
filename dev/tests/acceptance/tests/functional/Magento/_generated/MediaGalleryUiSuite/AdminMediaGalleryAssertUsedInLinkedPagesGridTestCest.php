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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4951848: Used in pages link")
 * @Description("User filters assets used in pages<h3>Test files</h3>app/code/Magento/MediaGalleryCmsUi/Test/Mftf/Test/AdminMediaGalleryAssertUsedInLinkedPagesGridTest.xml<br>")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/4951848")
 * @group media_gallery_ui
 */
class AdminMediaGalleryAssertUsedInLinkedPagesGridTestCest
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
	public function AdminMediaGalleryAssertUsedInLinkedPagesGridTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageNavigateToCreateNewPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadNavigateToCreateNewPage
		$I->comment("Exiting Action Group [navigateToCreateNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->comment("Entering Action Group [fillBasicPageFields] AdminCmsPageFillOutBasicFieldsActionGroup");
		$I->fillField("input[name=title]", "Test CMS Page"); // stepKey: fillTitleFillBasicPageFields
		$I->conditionalClick("div[data-index=content]", "input[name=content_heading]", false); // stepKey: expandContentTabIfCollapsedFillBasicPageFields
		$I->fillField("input[name=content_heading]", "Test Content Heading"); // stepKey: fillContentHeadingFillBasicPageFields
		$I->scrollTo("#cms_page_form_content"); // stepKey: scrollToPageContentFillBasicPageFields
		$I->fillField("#cms_page_form_content", "Sample page content. Yada yada yada."); // stepKey: fillContentFillBasicPageFields
		$I->conditionalClick("div[data-index=search_engine_optimisation]", "input[name=identifier]", false); // stepKey: clickExpandSearchEngineOptimisationIfCollapsedFillBasicPageFields
		$I->fillField("input[name=identifier]", "test-page-" . msq("_defaultCmsPage")); // stepKey: fillUrlKeyFillBasicPageFields
		$I->comment("Exiting Action Group [fillBasicPageFields] AdminCmsPageFillOutBasicFieldsActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryForPage] AdminOpenMediaGalleryFromPageNoEditorActionGroup");
		$I->conditionalClick("div[data-index=content]", "input[name=content_heading]", false); // stepKey: clickExpandContentOpenMediaGalleryForPage
		$I->waitForElementVisible(".scalable.action-add-image.plugin", 30); // stepKey: waitForInsertImageButtonOpenMediaGalleryForPage
		$I->scrollTo(".scalable.action-add-image.plugin", 0, -80); // stepKey: scrollToInsertImageButtonOpenMediaGalleryForPage
		$I->click(".scalable.action-add-image.plugin"); // stepKey: clickInsertImageOpenMediaGalleryForPage
		$I->comment("wait for initial media gallery load, where the gallery chrome loads (and triggers loading modal)");
		$I->waitForPageLoad(30); // stepKey: waitForMediaGalleryInitialLoadOpenMediaGalleryForPage
		$I->comment("wait for second media gallery load, where the gallery images load (and triggers loading modal once more)");
		$I->waitForPageLoad(30); // stepKey: waitForMediaGallerySecondaryLoadOpenMediaGalleryForPage
		$I->comment("Exiting Action Group [openMediaGalleryForPage] AdminOpenMediaGalleryFromPageNoEditorActionGroup");
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
		$I->comment("Entering Action Group [saveCmsPageAndContinue] AdminSaveAndContinueEditCmsPageActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageSaveCmsPageAndContinue
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveAndContinueButtonSaveCmsPageAndContinue
		$I->waitForPageLoad(10); // stepKey: waitForSaveAndContinueButtonSaveCmsPageAndContinueWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveAndContinueButtonSaveCmsPageAndContinue
		$I->waitForPageLoad(10); // stepKey: clickSaveAndContinueButtonSaveCmsPageAndContinueWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveCmsPageAndContinue
		$I->see("You saved the page.", "#messages div.message-success"); // stepKey: seeSuccessMessageSaveCmsPageAndContinue
		$I->comment("Exiting Action Group [saveCmsPageAndContinue] AdminSaveAndContinueEditCmsPageActionGroup");
		$I->comment("Entering Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGallery
		$I->comment("Exiting Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [resetMediaGalleryGridFiltersAgain] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetMediaGalleryGridFiltersAgain
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetMediaGalleryGridFiltersAgainWaitForPageLoad
		$I->comment("Exiting Action Group [resetMediaGalleryGridFiltersAgain] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [selectFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitBeforeClickOnFolderSelectFolder
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']"); // stepKey: selectFolderSelectFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectFolder
		$I->comment("Exiting Action Group [selectFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->comment("Entering Action Group [openViewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuOpenViewImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsOpenViewImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsOpenViewImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearOpenViewImageDetails
		$I->comment("Exiting Action Group [openViewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [clickUsedInPages] AdminEnhancedMediaGalleryClickEntityUsedInActionGroup");
		$I->click("//div[@class='attribute']/span[contains(text(), 'Used In')]/following-sibling::div/a[contains(text(), 'Pages')]"); // stepKey: openContextMenuClickUsedInPages
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickUsedInPages
		$I->comment("Exiting Action Group [clickUsedInPages] AdminEnhancedMediaGalleryClickEntityUsedInActionGroup");
		$I->comment("Entering Action Group [assertFilterApplied] AdminAssertMediaGalleryFilterPlaceHolderGridActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitVisibleFilterAssertFilterApplied
		$I->waitForElementVisible(".admin__data-grid-header .admin__data-grid-filters-current._show", 30); // stepKey: waitForRequestAssertFilterApplied
		$I->see("Title of the magento image", ".admin__data-grid-header .admin__data-grid-filters-current._show"); // stepKey: seeFilterAssertFilterApplied
		$I->comment("Exiting Action Group [assertFilterApplied] AdminAssertMediaGalleryFilterPlaceHolderGridActionGroup");
		$I->comment("Entering Action Group [deleteCmsPage] AdminDeleteCMSPageByUrlKeyActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridDeleteCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteCmsPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterDeleteCmsPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterClearFiltersDeleteCmsPage
		$I->click("//button[text()='Filters']"); // stepKey: clickFilterButtonDeleteCmsPage
		$I->fillField("//div[@class='admin__form-field-control']/input[@name='identifier']", "test-page-" . msq("_defaultCmsPage")); // stepKey: fillPageUrlKeyFilterDeleteCmsPage
		$I->click("//span[text()='Apply Filters']"); // stepKey: applyFilterDeleteCmsPage
		$I->waitForPageLoad(60); // stepKey: applyFilterDeleteCmsPageWaitForPageLoad
		$I->waitForElementVisible("//div[text()='test-page-" . msq("_defaultCmsPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']", 30); // stepKey: waitItemAppearsDeleteCmsPage
		$I->click("//div[text()='test-page-" . msq("_defaultCmsPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectDeleteCmsPage
		$I->click("//div[text()='test-page-" . msq("_defaultCmsPage") . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickDeleteDeleteCmsPage
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForOkButtonToBeVisibleDeleteCmsPage
		$I->waitForPageLoad(60); // stepKey: waitForOkButtonToBeVisibleDeleteCmsPageWaitForPageLoad
		$I->click(".action-primary.action-accept"); // stepKey: clickOkButtonDeleteCmsPage
		$I->waitForPageLoad(60); // stepKey: clickOkButtonDeleteCmsPageWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAppearedDeleteCmsPage
		$I->see("The page has been deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCmsPage
		$I->comment("Exiting Action Group [deleteCmsPage] AdminDeleteCMSPageByUrlKeyActionGroup");
		$I->comment("Entering Action Group [clearFiltersInPageGrid] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFiltersInPageGrid
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersInPageGridWaitForPageLoad
		$I->comment("Exiting Action Group [clearFiltersInPageGrid] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGallery
		$I->comment("Exiting Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [resetMediaGalleryGridFiltersAndAgain] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetMediaGalleryGridFiltersAndAgain
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetMediaGalleryGridFiltersAndAgainWaitForPageLoad
		$I->comment("Exiting Action Group [resetMediaGalleryGridFiltersAndAgain] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [selectFolderAgain] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitBeforeClickOnFolderSelectFolderAgain
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']"); // stepKey: selectFolderSelectFolderAgain
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectFolderAgain
		$I->comment("Exiting Action Group [selectFolderAgain] AdminMediaGalleryFolderSelectActionGroup");
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
