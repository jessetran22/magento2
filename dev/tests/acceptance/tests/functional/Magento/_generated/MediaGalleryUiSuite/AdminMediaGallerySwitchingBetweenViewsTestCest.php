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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1337102/scenarios/5060037: User switches between Views and checks if the folder is changed")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1337102/scenarios/5060037")
 * @Description("User switches between Views and checks if the folder is changed<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminMediaGallerySwitchingBetweenViewsTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGallerySwitchingBetweenViewsTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
		$I->comment("Entering Action Group [deleteView] AdminEnhancedMediaGalleryDeleteGridViewActionGroup");
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksDeleteView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksDeleteViewWaitForPageLoad
		$I->click("//a[@class='action-dropdown-menu-link'][contains(text(), 'New View')]/following-sibling::div/button[@class='action-edit']"); // stepKey: clickEditButtonDeleteView
		$I->seeElement("//div[@data-bind='afterRender: \$data.setToolbarNode']//input/following-sibling::div/button[@class='action-delete']"); // stepKey: seeDeleteButtonDeleteView
		$I->click("//div[@data-bind='afterRender: \$data.setToolbarNode']//input/following-sibling::div/button[@class='action-delete']"); // stepKey: clickDeleteButtonDeleteView
		$I->waitForPageLoad(10); // stepKey: waitForDeletionDeleteView
		$I->comment("Exiting Action Group [deleteView] AdminEnhancedMediaGalleryDeleteGridViewActionGroup");
		$I->comment("Entering Action Group [selectFolderForDelete] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitBeforeClickOnFolderSelectFolderForDelete
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']"); // stepKey: selectFolderSelectFolderForDelete
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectFolderForDelete
		$I->comment("Exiting Action Group [selectFolderForDelete] AdminMediaGalleryFolderSelectActionGroup");
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
	 * @Stories({"User switches between Views and checks if the folder is changed"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGallerySwitchingBetweenViewsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageOpenNewPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadOpenNewPage
		$I->comment("Exiting Action Group [openNewPage] AdminOpenCreateNewCMSPageActionGroup");
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
		$I->comment("Entering Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearFilters] ClearFiltersAdminDataGridActionGroup");
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
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContents
		$I->comment("Entering Action Group [saveCustomView] AdminEnhancedMediaGallerySaveCustomViewActionGroup");
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksSaveCustomView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksSaveCustomViewWaitForPageLoad
		$I->click(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] .action-dropdown-menu-item-last a"); // stepKey: saveViewSaveCustomView
		$I->waitForPageLoad(5); // stepKey: saveViewSaveCustomViewWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] ._edit input", "New View"); // stepKey: inputViewNameSaveCustomView
		$I->pressKey(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] ._edit input", \Facebook\WebDriver\WebDriverKeys::ENTER); // stepKey: pressEnterKeySaveCustomView
		$I->comment("Exiting Action Group [saveCustomView] AdminEnhancedMediaGallerySaveCustomViewActionGroup");
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
		$I->comment("Entering Action Group [selectDefaultView] AdminEnhancedMediaGallerySelectCustomBookmarksViewActionGroup");
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksSelectDefaultView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksSelectDefaultViewWaitForPageLoad
		$I->click("//a[@class='action-dropdown-menu-link'][contains(text(), 'Default View')]"); // stepKey: clickOnViewButtonSelectDefaultView
		$I->waitForPageLoad(5); // stepKey: clickOnViewButtonSelectDefaultViewWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitForGridLoadSelectDefaultView
		$I->comment("Exiting Action Group [selectDefaultView] AdminEnhancedMediaGallerySelectCustomBookmarksViewActionGroup");
		$I->comment("Entering Action Group [assertFolderIsChanged] AssertFolderIsChangedActionGroup");
		$I->assertNotEquals("folder" . msq("AdminMediaGalleryFolderData"), "category"); // stepKey: assertNotEqualAssertFolderIsChanged
		$I->comment("Exiting Action Group [assertFolderIsChanged] AssertFolderIsChangedActionGroup");
		$I->comment("Entering Action Group [switchBackToNewView] AdminEnhancedMediaGallerySelectCustomBookmarksViewActionGroup");
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksSwitchBackToNewView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksSwitchBackToNewViewWaitForPageLoad
		$I->click("//a[@class='action-dropdown-menu-link'][contains(text(), 'New View')]"); // stepKey: clickOnViewButtonSwitchBackToNewView
		$I->waitForPageLoad(5); // stepKey: clickOnViewButtonSwitchBackToNewViewWaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitForGridLoadSwitchBackToNewView
		$I->comment("Exiting Action Group [switchBackToNewView] AdminEnhancedMediaGallerySelectCustomBookmarksViewActionGroup");
		$I->comment("Entering Action Group [assertFilterApplied] AdminEnhancedMediaGalleryAssertActiveFiltersActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-expand']"); // stepKey: expandFiltersToCheckAppliedFilterAssertFilterApplied
		$I->see("folder" . msq("AdminMediaGalleryFolderData"), "//div[@class='media-gallery-container']//div[@class='admin__current-filters-list-wrap']//span[contains( ., 'folder" . msq("AdminMediaGalleryFolderData") . "')]"); // stepKey: verifyAppliedFilterAssertFilterApplied
		$I->comment("Exiting Action Group [assertFilterApplied] AdminEnhancedMediaGalleryAssertActiveFiltersActionGroup");
	}
}
