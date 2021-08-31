<?php
namespace Magento\AcceptanceTest\_default\Backend;

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
 * @group Cms
 * @Title("[NO TESTCASEID]: Admin should be able to cancel and close 'create folder' modal window using ESC key and                 to add image to new folder (using enter key) for WYSIWYG content of Block")
 * @Description("Admin should be able to cancel and close 'create folder' modal window using ESC key and                 to add image to new folder (using enter key) for WYSIWYG content of Block<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminCheckCreateFolderEscapeAndEnterHandlesForWYSIWYGBlockTest.xml<br>")
 */
class AdminCheckCreateFolderEscapeAndEnterHandlesForWYSIWYGBlockTestCest
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
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createPreReqBlock", "hook", "_defaultBlock", [], []); // stepKey: createPreReqBlock
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Entering Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$enableWYSIWYGEnableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled enabled", 60); // stepKey: enableWYSIWYGEnableWYSIWYG
		$I->comment($enableWYSIWYGEnableWYSIWYG);
		$I->comment("Exiting Action Group [enableWYSIWYG] EnabledWYSIWYGActionGroup");
		$I->comment("Entering Action Group [enableTinyMCE] CliEnableTinyMCEActionGroup");
		$enableTinyMCEEnableTinyMCE = $I->magentoCLI("config:set cms/wysiwyg/editor mage/adminhtml/wysiwyg/tiny_mce/tinymce5Adapter", 60); // stepKey: enableTinyMCEEnableTinyMCE
		$I->comment($enableTinyMCEEnableTinyMCE);
		$I->comment("Exiting Action Group [enableTinyMCE] CliEnableTinyMCEActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createPreReqBlock", "hook"); // stepKey: deletePreReqBlock
		$I->comment("Entering Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$disableWYSIWYGDisableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled disabled", 60); // stepKey: disableWYSIWYGDisableWYSIWYG
		$I->comment($disableWYSIWYGDisableWYSIWYG);
		$I->comment("Exiting Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"Cms"})
	 * @Stories({"WYSIWYG toolbar configuration with Magento Media Gallery"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckCreateFolderEscapeAndEnterHandlesForWYSIWYGBlockTest(AcceptanceTester $I)
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
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//button[text()='Select']"); // stepKey: clickSelectCreatedCMSBlockNavigateToCreatedCMSBlockPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//a[text()='Edit']"); // stepKey: navigateToCreatedCMSBlockNavigateToCreatedCMSBlockPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSBlockPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSBlockPage
		$I->comment("Exiting Action Group [navigateToCreatedCMSBlockPage] NavigateToCreatedCMSBlockPageActionGroup");
		$I->comment("Entering Action Group [clickInsertImageIcon] ClickInsertEditImageTinyMCEButtonActionGroup");
		$I->click("button[title='Insert/edit image']"); // stepKey: clickInsertImageBtnClickInsertImageIcon
		$I->waitForPageLoad(30); // stepKey: clickInsertImageBtnClickInsertImageIconWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickInsertImageIcon
		$I->comment("Exiting Action Group [clickInsertImageIcon] ClickInsertEditImageTinyMCEButtonActionGroup");
		$I->comment("Entering Action Group [clickBrowserBtn] ClickBrowseBtnOnUploadPopupActionGroup");
		$I->click(".tox-browse-url"); // stepKey: clickBrowseClickBrowserBtn
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1ClickBrowserBtn
		$I->comment("Exiting Action Group [clickBrowserBtn] ClickBrowseBtnOnUploadPopupActionGroup");
		$I->comment("Entering Action Group [VerifyMediaGalleryStorageBtn] VerifyMediaGalleryStorageActionsActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1VerifyMediaGalleryStorageBtn
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading1VerifyMediaGalleryStorageBtn
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading2VerifyMediaGalleryStorageBtn
		$I->see("Cancel", "#cancel"); // stepKey: seeCancelBtnVerifyMediaGalleryStorageBtn
		$I->see("Create Folder", "#new_folder"); // stepKey: seeCreateFolderBtnVerifyMediaGalleryStorageBtn
		$I->waitForPageLoad(30); // stepKey: seeCreateFolderBtnVerifyMediaGalleryStorageBtnWaitForPageLoad
		$I->comment("Exiting Action Group [VerifyMediaGalleryStorageBtn] VerifyMediaGalleryStorageActionsActionGroup");
		$I->comment("Entering Action Group [CreateImageFolderByEnterKeyPress] CreateImageFolderByEnterKeyActionGroup");
		$I->click("#new_folder"); // stepKey: createFolderCreateImageFolderByEnterKeyPress
		$I->waitForPageLoad(30); // stepKey: createFolderCreateImageFolderByEnterKeyPressWaitForPageLoad
		$I->waitForElementVisible("input[data-role='promptField']", 30); // stepKey: waitForPopUpCreateImageFolderByEnterKeyPress
		$I->fillField("input[data-role='promptField']", "Test" . msq("ImageFolder")); // stepKey: fillFolderNameCreateImageFolderByEnterKeyPress
		$I->pressKey("input[data-role='promptField']", \Facebook\WebDriver\WebDriverKeys::ENTER); // stepKey: acceptFolderNameCreateImageFolderByEnterKeyPress
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading3CreateImageFolderByEnterKeyPress
		$I->waitForPageLoad(15); // stepKey: waitForLoadingArrowToExpandCreateImageFolderByEnterKeyPress
		$I->conditionalClick("#root > .jstree-icon", "//li[@id='root' and contains(@class,'jstree-closed')]", true); // stepKey: clickArrowIfClosedCreateImageFolderByEnterKeyPress
		$I->conditionalClick("#d3lzaXd5Zw-- > .jstree-icon", "//li[@id='d3lzaXd5Zw--' and contains(@class,'jstree-closed')]", true); // stepKey: clickWysiwygArrowIfClosedCreateImageFolderByEnterKeyPress
		$I->waitForText("Test" . msq("ImageFolder"), 30); // stepKey: waitForNewFolderCreateImageFolderByEnterKeyPress
		$I->click("Test" . msq("ImageFolder")); // stepKey: clickOnCreatedFolderCreateImageFolderByEnterKeyPress
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading5CreateImageFolderByEnterKeyPress
		$I->comment("Exiting Action Group [CreateImageFolderByEnterKeyPress] CreateImageFolderByEnterKeyActionGroup");
		$I->comment("Entering Action Group [DeleteCreatedFolder] DeleteFolderActionGroup");
		$I->click("Test" . msq("ImageFolder")); // stepKey: clickOnCreatedFolderDeleteCreatedFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingDeleteCreatedFolder
		$I->see("Delete Folder", "#delete_folder"); // stepKey: seeDeleteFolderBtnDeleteCreatedFolder
		$I->click("#delete_folder"); // stepKey: clickDeleteFolderBtnDeleteCreatedFolder
		$I->waitForText("OK", 30); // stepKey: waitForConfirmDeleteCreatedFolder
		$I->click(".action-primary.action-accept"); // stepKey: confirmDeleteDeleteCreatedFolder
		$I->waitForPageLoad(30); // stepKey: waitForPopUpHideDeleteCreatedFolder
		$I->dontSeeElement("Test" . msq("ImageFolder")); // stepKey: dontSeeFolderNameDeleteCreatedFolder
		$I->comment("Exiting Action Group [DeleteCreatedFolder] DeleteFolderActionGroup");
		$I->comment("Entering Action Group [CancelImageFolderCreation] PressEscImageFolderActionGroup");
		$I->click("#new_folder"); // stepKey: createFolderCancelImageFolderCreation
		$I->waitForPageLoad(30); // stepKey: createFolderCancelImageFolderCreationWaitForPageLoad
		$I->waitForElementVisible("input[data-role='promptField']", 30); // stepKey: waitForPopUpCancelImageFolderCreation
		$I->fillField("input[data-role='promptField']", "Test" . msq("ImageFolder")); // stepKey: fillFolderNameCancelImageFolderCreation
		$I->pressKey("input[data-role='promptField']", \Facebook\WebDriver\WebDriverKeys::ESCAPE); // stepKey: cancelFolderNameCancelImageFolderCreation
		$I->waitForPageLoad(30); // stepKey: waitForPopUpHideCancelImageFolderCreation
		$I->dontSeeElement("Test" . msq("ImageFolder")); // stepKey: dontSeeFolderNameCancelImageFolderCreation
		$I->comment("Exiting Action Group [CancelImageFolderCreation] PressEscImageFolderActionGroup");
	}
}
