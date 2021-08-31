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
 * @Title("https://github.com/magento/adobe-stock-integration/issues/1776: User uses Sort by Name A to Z in Standalone Media Gallery")
 * @TestCaseId("https://github.com/magento/adobe-stock-integration/issues/1776")
 * @Description("User uses Sort by Name A to Z in Standalone Media Gallery<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminMediaGallerySortByNameAToZTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGallerySortByNameAToZTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openStandaloneMediaGalleryPage] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGalleryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGalleryPage
		$I->comment("Exiting Action Group [openStandaloneMediaGalleryPage] AdminOpenStandaloneMediaGalleryActionGroup");
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
		$I->comment("Entering Action Group [selectParentFolderForDelete] AdminMediaGalleryFolderSelectActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='parentFolder']", 30); // stepKey: waitBeforeClickOnFolderSelectParentFolderForDelete
		$I->click("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='parentFolder']"); // stepKey: selectFolderSelectParentFolderForDelete
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectParentFolderForDelete
		$I->comment("Exiting Action Group [selectParentFolderForDelete] AdminMediaGalleryFolderSelectActionGroup");
		$I->comment("Entering Action Group [deleteParentFolder] AdminMediaGalleryFolderDeleteActionGroup");
		$I->waitForElementVisible("#delete_folder:not(.disabled)", 30); // stepKey: waitBeforeDeleteButtonWillBeActiveDeleteParentFolder
		$I->waitForPageLoad(30); // stepKey: waitBeforeDeleteButtonWillBeActiveDeleteParentFolderWaitForPageLoad
		$I->click("#delete_folder:not(.disabled)"); // stepKey: clickDeleteButtonDeleteParentFolder
		$I->waitForPageLoad(30); // stepKey: clickDeleteButtonDeleteParentFolderWaitForPageLoad
		$I->waitForElementVisible("//h1[contains(text(), 'Are you sure you want to delete this folder?')]", 30); // stepKey: waitBeforeModalAppearsDeleteParentFolder
		$I->click("//footer//button/span[contains(text(), 'OK')]"); // stepKey: clickConfirmDeleteButtonDeleteParentFolder
		$I->waitForPageLoad(30); // stepKey: clickConfirmDeleteButtonDeleteParentFolderWaitForPageLoad
		$I->comment("Exiting Action Group [deleteParentFolder] AdminMediaGalleryFolderDeleteActionGroup");
		$I->comment("Entering Action Group [assertParentFolderWasDeleted] AdminMediaGalleryAssertFolderDoesNotExistActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForFolderTreeReloadsAssertParentFolderWasDeleted
		$I->dontSeeElement("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='parentFolder']"); // stepKey: folderDoesNotExistAssertParentFolderWasDeleted
		$I->comment("Exiting Action Group [assertParentFolderWasDeleted] AdminMediaGalleryAssertFolderDoesNotExistActionGroup");
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
	 * @Stories({"User uses Sort by Name A to Z in Standalone Media Gallery"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGallerySortByNameAToZTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openStandaloneMediaGalleryPage] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGalleryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGalleryPage
		$I->comment("Exiting Action Group [openStandaloneMediaGalleryPage] AdminOpenStandaloneMediaGalleryActionGroup");
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
		$I->comment("Entering Action Group [openParentFolderForm] AdminMediaGalleryOpenNewFolderFormActionGroup");
		$I->click("#create_folder"); // stepKey: clickCreateNewFolderButtonOpenParentFolderForm
		$I->waitForElementVisible("//h1[contains(text(), 'New Folder Name')]", 30); // stepKey: waitForModalOpenOpenParentFolderForm
		$I->comment("Exiting Action Group [openParentFolderForm] AdminMediaGalleryOpenNewFolderFormActionGroup");
		$I->comment("Entering Action Group [createParentFolder] AdminMediaGalleryCreateNewFolderActionGroup");
		$I->fillField("[name=folder_name]", "parentFolder"); // stepKey: setFolderNameCreateParentFolder
		$I->click("//button/span[contains(text(),'Confirm')]"); // stepKey: clickCreateButtonCreateParentFolder
		$I->waitForPageLoad(30); // stepKey: clickCreateButtonCreateParentFolderWaitForPageLoad
		$I->comment("Exiting Action Group [createParentFolder] AdminMediaGalleryCreateNewFolderActionGroup");
		$I->comment("Entering Action Group [assertParentFolderCreated] AdminMediaGalleryAssertFolderNameActionGroup");
		$I->waitForElementVisible("//div[contains(@class, 'media-directory-container')]//ul//li//a[normalize-space(text())='parentFolder']", 30); // stepKey: waitForFolderAssertParentFolderCreated
		$I->comment("Exiting Action Group [assertParentFolderCreated] AdminMediaGalleryAssertFolderNameActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadAfterParentFolderCreated
		$I->comment("Entering Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadImage
		$I->attachFile("#image-uploader-input", "magento.jpg"); // stepKey: uploadImageUploadImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadImage
		$I->comment("Exiting Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [uploadSecondImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadSecondImage
		$I->attachFile("#image-uploader-input", "magento2.jpg"); // stepKey: uploadImageUploadSecondImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadSecondImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadSecondImage
		$I->comment("Exiting Action Group [uploadSecondImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [uploadThirdImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadThirdImage
		$I->attachFile("#image-uploader-input", "magento3.jpg"); // stepKey: uploadImageUploadThirdImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadThirdImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadThirdImage
		$I->comment("Exiting Action Group [uploadThirdImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoad
		$I->comment("Entering Action Group [sortByNameAToZ] AdminEnhancedMediaGalleryClickSortActionGroup");
		$I->click("div[class='masonry-image-sortby'] select"); // stepKey: clickOnSortDropdownSortByNameAToZ
		$I->click("//div[@class='masonry-image-sortby'] //option[@value='name_az']"); // stepKey: clickOnSortOptionSortByNameAToZ
		$I->waitForPageLoad(30); // stepKey: waitForLoadSortByNameAToZ
		$I->comment("Exiting Action Group [sortByNameAToZ] AdminEnhancedMediaGalleryClickSortActionGroup");
		$I->comment("Entering Action Group [assertImagePositionAfterSortByNameAToZ] AssertAdminEnhancedMediaGallerySortByActionGroup");
		$getFirstImageSrcAfterSortAssertImagePositionAfterSortByNameAToZ = $I->grabAttributeFrom("div[class='masonry-image-column'][data-repeat-index='0'] img", "src"); // stepKey: getFirstImageSrcAfterSortAssertImagePositionAfterSortByNameAToZ
		$getSecondImageSrcAfterSortAssertImagePositionAfterSortByNameAToZ = $I->grabAttributeFrom("div[class='masonry-image-column'][data-repeat-index='1'] img", "src"); // stepKey: getSecondImageSrcAfterSortAssertImagePositionAfterSortByNameAToZ
		$getThirdImageSrcAfterSortAssertImagePositionAfterSortByNameAToZ = $I->grabAttributeFrom("div[class='masonry-image-column'][data-repeat-index='2'] img", "src"); // stepKey: getThirdImageSrcAfterSortAssertImagePositionAfterSortByNameAToZ
		$I->assertStringContainsString("magento.jpg", $getFirstImageSrcAfterSortAssertImagePositionAfterSortByNameAToZ); // stepKey: assertFirstImagePositionAfterSortAssertImagePositionAfterSortByNameAToZ
		$I->assertStringContainsString("magento2.jpg", $getSecondImageSrcAfterSortAssertImagePositionAfterSortByNameAToZ); // stepKey: assertSecondImagePositionAfterSortAssertImagePositionAfterSortByNameAToZ
		$I->assertStringContainsString("magento3.jpg", $getThirdImageSrcAfterSortAssertImagePositionAfterSortByNameAToZ); // stepKey: assertThirdImagePositionAfterSortAssertImagePositionAfterSortByNameAToZ
		$I->comment("Exiting Action Group [assertImagePositionAfterSortByNameAToZ] AssertAdminEnhancedMediaGallerySortByActionGroup");
	}
}
