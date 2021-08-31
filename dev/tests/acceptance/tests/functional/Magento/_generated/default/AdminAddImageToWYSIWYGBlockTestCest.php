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
 * @Title("MAGETWO-84376: Admin should be able to add image to WYSIWYG content of Block")
 * @Description("Admin should be able to add image to WYSIWYG content of Block<h3>Test files</h3>app/code/Magento/Cms/Test/Mftf/Test/AdminAddImageToWYSIWYGBlockTest.xml<br>")
 * @TestCaseId("MAGETWO-84376")
 */
class AdminAddImageToWYSIWYGBlockTestCest
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
		$I->createEntity("createCMSPage", "hook", "_defaultCmsPage", [], []); // stepKey: createCMSPage
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
		$I->comment("Entering Action Group [navigateToMediaGallery] NavigateToMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnAdminCategoryPageNavigateToMediaGallery
		$I->waitForElementVisible("div[data-index='content']", 30); // stepKey: waitForContentSectionNavigateToMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForContentSectionNavigateToMediaGalleryWaitForPageLoad
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: openContentSectionNavigateToMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToMediaGallery
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Select from Gallery']", 30); // stepKey: waitForSelectFromGalleryButtonNavigateToMediaGallery
		$I->click("//*[@class='file-uploader-area']/label[text()='Select from Gallery']"); // stepKey: clickSelectFromGalleryButtonNavigateToMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToMediaGallery
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearNavigateToMediaGallery
		$I->comment("Exiting Action Group [navigateToMediaGallery] NavigateToMediaGalleryActionGroup");
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
		$I->comment("Entering Action Group [amOnEditPage] AdminOpenCMSPagesGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: navigateToCMSPagesGridAmOnEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnEditPage
		$I->comment("Exiting Action Group [amOnEditPage] AdminOpenCMSPagesGridActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilter
		$I->waitForPageLoad(30); // stepKey: waitForGridReload
		$I->deleteEntity("createPreReqBlock", "hook"); // stepKey: deletePreReqBlock
		$I->deleteEntity("createCMSPage", "hook"); // stepKey: deletePreReqCMSPage
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
	 * @Stories({"MAGETWO-42041-Default WYSIWYG toolbar configuration with Magento Media Gallery"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddImageToWYSIWYGBlockTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [assignBlockToCMSPage] AssignBlockToCMSPage");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page"); // stepKey: amOnEditPageAssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1AssignBlockToCMSPage
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterAssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForGridReloadAssignBlockToCMSPage
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescending1AssignBlockToCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinish1AssignBlockToCMSPage
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescending2AssignBlockToCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinish1AssignBlockToCMSPage
		$I->waitForElementVisible("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']", 30); // stepKey: waitForCMSPageGridAssignBlockToCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectAssignBlockToCMSPage
		$I->waitForElementVisible("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']", 30); // stepKey: waitForEditLinkAssignBlockToCMSPage
		$I->click("//div[text()='" . $I->retrieveEntityField('createCMSPage', 'identifier', 'test') . "']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Edit']"); // stepKey: clickEditAssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AssignBlockToCMSPage
		$I->click("div[data-index=content]"); // stepKey: clickContentTabAssignBlockToCMSPage
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCEAssignBlockToCMSPage
		$I->seeElement("button[aria-label='Insert Widget']"); // stepKey: seeWidgetIconAssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: seeWidgetIconAssignBlockToCMSPageWaitForPageLoad
		$I->click("button[aria-label='Insert Widget']"); // stepKey: clickInsertWidgetIconAssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetIconAssignBlockToCMSPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3AssignBlockToCMSPage
		$I->selectOption("#select_widget_type", "CMS Static Block"); // stepKey: selectCMSStaticBlockAssignBlockToCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading1AssignBlockToCMSPage
		$I->selectOption("select[name='parameters[template]']", "CMS Static Block Default Template"); // stepKey: selectTemplateAssignBlockToCMSPage
		$I->click(".btn-chooser"); // stepKey: clickSelectPageBtnAssignBlockToCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading2AssignBlockToCMSPage
		$I->fillField("//input[@name='chooser_identifier']", $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test')); // stepKey: fillBlockIdentifierAssignBlockToCMSPage
		$I->click("//div[@class='modal-inner-wrap']//button[@title='Search']"); // stepKey: clickSearchBtnAssignBlockToCMSPage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinish2AssignBlockToCMSPage
		$I->waitForElementVisible("//td[contains(text(),'" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "')]", 30); // stepKey: waitForBlockTitleAssignBlockToCMSPage
		$I->click("//td[contains(text(),'" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "')]"); // stepKey: selectPreCreateBlockAssignBlockToCMSPage
		$I->wait(3); // stepKey: wait1AssignBlockToCMSPage
		$I->click("#insert_button"); // stepKey: clickInsertWidgetBtnAssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: clickInsertWidgetBtnAssignBlockToCMSPageWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading3AssignBlockToCMSPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad4AssignBlockToCMSPage
		$I->click("//button[@data-ui-id='save-button-dropdown']"); // stepKey: expandButtonMenuAssignBlockToCMSPage
		$I->waitForPageLoad(10); // stepKey: expandButtonMenuAssignBlockToCMSPageWaitForPageLoad
		$I->waitForElementVisible("//ul[@data-ui-id='save-button-dropdown-menu']", 30); // stepKey: waitForSplitButtonMenuVisibleAssignBlockToCMSPage
		$I->waitForPageLoad(10); // stepKey: waitForSplitButtonMenuVisibleAssignBlockToCMSPageWaitForPageLoad
		$I->click("#save_and_close"); // stepKey: clickSavePageAssignBlockToCMSPage
		$I->waitForPageLoad(10); // stepKey: clickSavePageAssignBlockToCMSPageWaitForPageLoad
		$I->comment("Exiting Action Group [assignBlockToCMSPage] AssignBlockToCMSPage");
		$I->comment("Entering Action Group [navigateToCreatedCMSBlockPage1] NavigateToCreatedCMSBlockPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/block/"); // stepKey: navigateToCMSBlocksGridNavigateToCreatedCMSBlockPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1NavigateToCreatedCMSBlockPage1
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[contains(text(), 'Clear all')]", "//div[@class='admin__data-grid-header']//span[contains(text(), 'Active filters:')]", true); // stepKey: clickToResetFilterNavigateToCreatedCMSBlockPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2NavigateToCreatedCMSBlockPage1
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: clickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFirstIdSortDescendingToFinishNavigateToCreatedCMSBlockPage1
		$I->comment("Conditional Click again in case it goes from default state to ascending on first click");
		$I->conditionalClick("//div[contains(@data-role, 'grid-wrapper')]/table/thead/tr/th/span[contains(text(), 'ID')]", "//span[contains(text(), 'ID')]/parent::th[not(contains(@class, '_descend'))]/parent::tr/parent::thead/parent::table/parent::div[contains(@data-role, 'grid-wrapper')]", true); // stepKey: secondClickToAttemptSortByIdDescendingNavigateToCreatedCMSBlockPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForSecondIdSortDescendingToFinishNavigateToCreatedCMSBlockPage1
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//button[text()='Select']"); // stepKey: clickSelectCreatedCMSBlockNavigateToCreatedCMSBlockPage1
		$I->click("//div[text()='" . $I->retrieveEntityField('createPreReqBlock', 'identifier', 'test') . "']//parent::td//following-sibling::td//a[text()='Edit']"); // stepKey: navigateToCreatedCMSBlockNavigateToCreatedCMSBlockPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3NavigateToCreatedCMSBlockPage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskOfStagingSectionNavigateToCreatedCMSBlockPage1
		$I->comment("Exiting Action Group [navigateToCreatedCMSBlockPage1] NavigateToCreatedCMSBlockPageActionGroup");
		$I->selectOption("select[name=store_id]", "All Store View"); // stepKey: selectAllStoreView
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCE
		$I->click("button[title='Insert/edit image']"); // stepKey: clickInsertImageIcon
		$I->waitForPageLoad(30); // stepKey: clickInsertImageIconWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
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
		$I->comment("Entering Action Group [navigateToFolder] NavigateToMediaFolderActionGroup");
		$I->conditionalClick("#root > .jstree-icon", "//li[@id='root' and contains(@class,'jstree-closed')]", true); // stepKey: clickArrowIfClosedNavigateToFolder
		$I->waitForPageLoad(10); // stepKey: waitForDirectoriesTreeBuildingNavigateToFolder
		$I->waitForText("Storage Root", 30); // stepKey: waitForNewFolderNavigateToFolder
		$I->click("Storage Root"); // stepKey: clickOnCreatedFolderNavigateToFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingNavigateToFolder
		$I->comment("Exiting Action Group [navigateToFolder] NavigateToMediaFolderActionGroup");
		$I->comment("Entering Action Group [CreateImageFolder] CreateImageFolderActionGroup");
		$I->click("#new_folder"); // stepKey: createFolderCreateImageFolder
		$I->waitForPageLoad(30); // stepKey: createFolderCreateImageFolderWaitForPageLoad
		$I->waitForElementVisible("input[data-role='promptField']", 30); // stepKey: waitForPopUpCreateImageFolder
		$I->fillField("input[data-role='promptField']", "Test" . msq("ImageFolder")); // stepKey: fillFolderNameCreateImageFolder
		$I->click(".action-primary.action-accept"); // stepKey: acceptFolderNameCreateImageFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading3CreateImageFolder
		$I->waitForPageLoad(15); // stepKey: waitForLoadingArrowToExpandCreateImageFolder
		$I->conditionalClick("#root > .jstree-icon", "//li[@id='root' and contains(@class,'jstree-closed')]", true); // stepKey: clickArrowIfClosedCreateImageFolder
		$I->conditionalClick("#d3lzaXd5Zw-- > .jstree-icon", "//li[@id='d3lzaXd5Zw--' and contains(@class,'jstree-closed')]", true); // stepKey: clickWysiwygArrowIfClosedCreateImageFolder
		$I->waitForText("Test" . msq("ImageFolder"), 30); // stepKey: waitForNewFolderCreateImageFolder
		$I->click("Test" . msq("ImageFolder")); // stepKey: clickOnCreatedFolderCreateImageFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading5CreateImageFolder
		$I->comment("Exiting Action Group [CreateImageFolder] CreateImageFolderActionGroup");
		$I->comment("Entering Action Group [attachImage1] AttachImageActionGroup");
		$I->attachFile(".fileupload", "magento.jpg"); // stepKey: uploadImageAttachImage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAttachImage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAttachImage1
		$I->waitForElementVisible("//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento.jpg')]|//img[contains(@alt,'magento_') and contains(@alt,'.jpg')]", 30); // stepKey: waitForUploadImageAttachImage1
		$I->comment("Exiting Action Group [attachImage1] AttachImageActionGroup");
		$I->comment("Entering Action Group [deleteImage] DeleteImageActionGroup");
		$I->see("Delete Selected", "#delete_files"); // stepKey: seeDeleteBtnDeleteImage
		$I->waitForPageLoad(30); // stepKey: seeDeleteBtnDeleteImageWaitForPageLoad
		$I->click("#delete_files"); // stepKey: clickDeleteSelectedDeleteImage
		$I->waitForPageLoad(30); // stepKey: clickDeleteSelectedDeleteImageWaitForPageLoad
		$I->waitForText("OK", 30); // stepKey: waitForConfirmDeleteImage
		$I->click(".action-primary.action-accept"); // stepKey: confirmDeleteDeleteImage
		$I->waitForElementNotVisible("//small[text()='magento.jpg']", 30); // stepKey: waitForImageDeletedDeleteImage
		$I->dontSeeElement("//small[text()='magento.jpg']"); // stepKey: dontSeeImageDeleteImage
		$I->comment("Exiting Action Group [deleteImage] DeleteImageActionGroup");
		$I->comment("Entering Action Group [attachImage2] AttachImageActionGroup");
		$I->attachFile(".fileupload", "magento.jpg"); // stepKey: uploadImageAttachImage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAttachImage2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAttachImage2
		$I->waitForElementVisible("//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento.jpg')]|//img[contains(@alt,'magento_') and contains(@alt,'.jpg')]", 30); // stepKey: waitForUploadImageAttachImage2
		$I->comment("Exiting Action Group [attachImage2] AttachImageActionGroup");
		$I->comment("Entering Action Group [insertImage] SaveImageActionGroup");
		$I->click("#insert_files"); // stepKey: clickInsertBtnInsertImage
		$I->waitForPageLoad(30); // stepKey: clickInsertBtnInsertImageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadInsertImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearInsertImage
		$I->comment("Exiting Action Group [insertImage] SaveImageActionGroup");
		$I->comment("Entering Action Group [fillOutUploadImagePopup] FillOutUploadImagePopupActionGroup");
		$I->waitForElementVisible(".tox-dialog__footer button[title='Save']", 30); // stepKey: waitForOkBtnFillOutUploadImagePopup
		$I->fillField("//label[text()='Alternative description']/parent::div//input", "Image content. Yeah."); // stepKey: fillImageDescriptionFillOutUploadImagePopup
		$I->fillField("//label[text()='Height']/parent::div//input", "1000"); // stepKey: fillImageHeightFillOutUploadImagePopup
		$I->click(".tox-dialog__footer button[title='Save']"); // stepKey: clickOkBtnFillOutUploadImagePopup
		$I->waitForPageLoad(30); // stepKey: wait3FillOutUploadImagePopup
		$I->comment("Exiting Action Group [fillOutUploadImagePopup] FillOutUploadImagePopupActionGroup");
		$I->click("#save-button"); // stepKey: clickSaveBlock
		$I->waitForPageLoad(10); // stepKey: clickSaveBlockWaitForPageLoad
		$I->amOnPage($I->retrieveEntityField('createCMSPage', 'identifier', 'test')); // stepKey: amOnPageTestPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad11
		$I->comment("see image on Storefront");
		$I->seeElement(".widget.block.block-static-block>p>img"); // stepKey: assertMediaDescription
		$I->seeElementInDOM("//img[contains(@src,'magento')]"); // stepKey: assertMediaSource
	}
}
