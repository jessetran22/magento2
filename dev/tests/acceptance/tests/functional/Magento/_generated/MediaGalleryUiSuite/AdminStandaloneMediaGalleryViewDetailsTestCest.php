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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1337102/scenarios/4503223: View image details in standalone media gallery")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1337102/scenarios/4503223")
 * @Description("User views basic image attributes in Media Gallery<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminStandaloneMediaGalleryViewDetailsTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminStandaloneMediaGalleryViewDetailsTestCest
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
		$I->comment("Entering Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGallery
		$I->comment("Exiting Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGallery
		$I->comment("Exiting Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
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
		$I->wait(5); // stepKey: waitFilterReallyCleared
		$I->comment("Entering Action Group [selectFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='assetTestFolder']", 30); // stepKey: waitBeforeClickOnFolderSelectFolder
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='assetTestFolder']"); // stepKey: selectFolderSelectFolder
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
		$I->dontSeeElement("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='assetTestFolder']"); // stepKey: folderDoesNotExistAssertFolderWasDeleted
		$I->comment("Exiting Action Group [assertFolderWasDeleted] AdminMediaGalleryAssertFolderDoesNotExistActionGroup");
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
	 * @Stories({"[Story # 38] User views basic image attributes in Media Gallery"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminStandaloneMediaGalleryViewDetailsTest(AcceptanceTester $I)
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
		$I->wait(5); // stepKey: waitFilterReallyCleared
		$I->comment("Entering Action Group [openNewFolderForm] AdminMediaGalleryOpenNewFolderFormActionGroup");
		$I->click("#create_folder"); // stepKey: clickCreateNewFolderButtonOpenNewFolderForm
		$I->waitForElementVisible("//h1[contains(text(), 'New Folder Name')]", 30); // stepKey: waitForModalOpenOpenNewFolderForm
		$I->comment("Exiting Action Group [openNewFolderForm] AdminMediaGalleryOpenNewFolderFormActionGroup");
		$I->comment("Entering Action Group [createNewFolder] AdminMediaGalleryCreateNewFolderActionGroup");
		$I->fillField("[name=folder_name]", "assetTestFolder"); // stepKey: setFolderNameCreateNewFolder
		$I->click("//button/span[contains(text(),'Confirm')]"); // stepKey: clickCreateButtonCreateNewFolder
		$I->waitForPageLoad(30); // stepKey: clickCreateButtonCreateNewFolderWaitForPageLoad
		$I->comment("Exiting Action Group [createNewFolder] AdminMediaGalleryCreateNewFolderActionGroup");
		$I->comment("Entering Action Group [assertNewFolderCreated] AdminMediaGalleryAssertFolderNameActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='assetTestFolder']", 30); // stepKey: waitForFolderAssertNewFolderCreated
		$I->comment("Exiting Action Group [assertNewFolderCreated] AdminMediaGalleryAssertFolderNameActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadAfterNewFolderCreated
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
		$I->comment("Entering Action Group [verifyImageDetails] AdminEnhancedMediaGalleryVerifyImageDetailsActionGroup");
		$grabImageTitleVerifyImageDetails = $I->grabTextFrom(".image-title"); // stepKey: grabImageTitleVerifyImageDetails
		$I->assertStringContainsString("magento", $grabImageTitleVerifyImageDetails); // stepKey: verifyImageTitleVerifyImageDetails
		$grabContentTypeVerifyImageDetails = $I->grabTextFrom("span[data-ui-id='content-type']"); // stepKey: grabContentTypeVerifyImageDetails
		$I->assertStringContainsStringIgnoringCase("jpg", $grabContentTypeVerifyImageDetails); // stepKey: verifyContentTypeVerifyImageDetails
		$grabTypeVerifyImageDetails = $I->grabTextFrom("//div[@class='attribute']/span[contains(text(), 'Type')]/following-sibling::div"); // stepKey: grabTypeVerifyImageDetails
		$I->assertStringContainsString("Image", $grabTypeVerifyImageDetails); // stepKey: verifyTypeVerifyImageDetails
		$I->comment("Exiting Action Group [verifyImageDetails] AdminEnhancedMediaGalleryVerifyImageDetailsActionGroup");
		$I->comment("Entering Action Group [verifyFilename] AdminEnhancedMediaGalleryVerifyImageFilenameActionGroup");
		$grabFilenameVerifyFilename = $I->grabTextFrom(".image-details-section.filename p"); // stepKey: grabFilenameVerifyFilename
		$I->assertStringContainsString("magento.jpg", $grabFilenameVerifyFilename); // stepKey: verifyFilenameVerifyFilename
		$I->comment("Exiting Action Group [verifyFilename] AdminEnhancedMediaGalleryVerifyImageFilenameActionGroup");
		$I->comment("Entering Action Group [closeDetails] AdminEnhancedMediaGalleryCloseViewDetailsActionGroup");
		$I->click("#image-details-action-cancel"); // stepKey: clickCancelCloseDetails
		$I->waitForPageLoad(10); // stepKey: clickCancelCloseDetailsWaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForElementRenderCloseDetails
		$I->comment("Exiting Action Group [closeDetails] AdminEnhancedMediaGalleryCloseViewDetailsActionGroup");
	}
}
