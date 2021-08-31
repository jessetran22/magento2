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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4456547; https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4457075: Creating, deleting new folder functionality in Media Gallery")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4456547; https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4457075")
 * @Description("Creating, deleting new folder functionality in Media Gallery<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminMediaGalleryCreateDeleteFolderTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryCreateDeleteFolderTestCest
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
		$I->comment("Entering Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGallery
		$I->comment("Exiting Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
	}

	/**
	 * @Features({"MediaGalleryUi"})
	 * @Stories({"Creating, deleting new folder functionality in Media Gallery"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryCreateDeleteFolderTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openNewFolderForm] AdminMediaGalleryOpenNewFolderFormActionGroup");
		$I->click("#create_folder"); // stepKey: clickCreateNewFolderButtonOpenNewFolderForm
		$I->waitForElementVisible("//h1[contains(text(), 'New Folder Name')]", 30); // stepKey: waitForModalOpenOpenNewFolderForm
		$I->comment("Exiting Action Group [openNewFolderForm] AdminMediaGalleryOpenNewFolderFormActionGroup");
		$I->comment("Entering Action Group [createNewFolderWithNotValidName] AdminMediaGalleryCreateNewFolderActionGroup");
		$I->fillField("[name=folder_name]", ",.?/:;'[{]}|~`!@#$%^*()_=+"); // stepKey: setFolderNameCreateNewFolderWithNotValidName
		$I->click("//button/span[contains(text(),'Confirm')]"); // stepKey: clickCreateButtonCreateNewFolderWithNotValidName
		$I->waitForPageLoad(30); // stepKey: clickCreateButtonCreateNewFolderWithNotValidNameWaitForPageLoad
		$I->comment("Exiting Action Group [createNewFolderWithNotValidName] AdminMediaGalleryCreateNewFolderActionGroup");
		$grabValidationMessage = $I->grabTextFrom("label.mage-error"); // stepKey: grabValidationMessage
		$I->assertStringContainsString("Please use only letters (a-z or A-Z) or numbers (0-9) in this field. No spaces or other characters are allowed.", $grabValidationMessage); // stepKey: assertFirst
		$I->comment("Entering Action Group [createNewFolder] AdminMediaGalleryCreateNewFolderActionGroup");
		$I->fillField("[name=folder_name]", "folder" . msq("AdminMediaGalleryFolderData")); // stepKey: setFolderNameCreateNewFolder
		$I->click("//button/span[contains(text(),'Confirm')]"); // stepKey: clickCreateButtonCreateNewFolder
		$I->waitForPageLoad(30); // stepKey: clickCreateButtonCreateNewFolderWaitForPageLoad
		$I->comment("Exiting Action Group [createNewFolder] AdminMediaGalleryCreateNewFolderActionGroup");
		$I->comment("Entering Action Group [assertNewFolderCreated] AdminMediaGalleryAssertFolderNameActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitForFolderAssertNewFolderCreated
		$I->comment("Exiting Action Group [assertNewFolderCreated] AdminMediaGalleryAssertFolderNameActionGroup");
		$I->comment("Entering Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGallery
		$I->comment("Exiting Action Group [openMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [selectFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitBeforeClickOnFolderSelectFolder
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']"); // stepKey: selectFolderSelectFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectFolder
		$I->comment("Exiting Action Group [selectFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->seeElement("#delete_folder"); // stepKey: deleteFolderButtonIsNotDisabled
		$I->waitForPageLoad(30); // stepKey: deleteFolderButtonIsNotDisabledWaitForPageLoad
		$I->comment("Entering Action Group [unselectFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitBeforeClickOnFolderUnselectFolder
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']"); // stepKey: selectFolderUnselectFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsUnselectFolder
		$I->comment("Exiting Action Group [unselectFolder] AdminMediaGalleryFolderSelectActionGroup");
		$I->seeElement("#delete_folder, :disabled"); // stepKey: deleteFolderButtonIsDisabledAgain
		$I->waitForPageLoad(30); // stepKey: deleteFolderButtonIsDisabledAgainWaitForPageLoad
		$I->comment("Entering Action Group [selectFolderForDelete] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitBeforeClickOnFolderSelectFolderForDelete
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']"); // stepKey: selectFolderSelectFolderForDelete
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectFolderForDelete
		$I->comment("Exiting Action Group [selectFolderForDelete] AdminMediaGalleryFolderSelectActionGroup");
		$I->click("#delete_folder"); // stepKey: clickDeleteButton
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonWaitForPageLoad
		$I->waitForElementVisible("//footer//button/span[contains(text(), 'Cancel')]", 30); // stepKey: waitBeforeModalLoads
		$I->click("//footer//button/span[contains(text(), 'Cancel')]"); // stepKey: cancelDeleteFolder
		$I->comment("Entering Action Group [assertFolderWasNotDeleted] AdminMediaGalleryAssertFolderNameActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='folder" . msq("AdminMediaGalleryFolderData") . "']", 30); // stepKey: waitForFolderAssertFolderWasNotDeleted
		$I->comment("Exiting Action Group [assertFolderWasNotDeleted] AdminMediaGalleryAssertFolderNameActionGroup");
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
	}
}
