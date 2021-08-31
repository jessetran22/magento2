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
 * @group Catalog
 * @Title("MAGETWO-84373: Admin should be able to add image to WYSIWYG Editor on Catalog Page")
 * @Description("Admin should be able to add image to WYSIWYG Editor on Catalog Page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminAddImageToWYSIWYGCatalogTest.xml<br>")
 * @TestCaseId("MAGETWO-84373")
 */
class AdminAddImageToWYSIWYGCatalogTestCest
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
		$I->comment("Entering Action Group [DeleteCategory] DeleteCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteCategory
		$I->click("//a/span[contains(text(), 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]"); // stepKey: clickCategoryLinkDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkDeleteCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandToSeeAllCategoriesDeleteCategory
		$I->dontSee("//a/span[contains(text(), 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]"); // stepKey: dontSeeCategoryInTreeDeleteCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeDeleteCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [DeleteCategory] DeleteCategoryActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"MAGETWO-42041-Default WYSIWYG toolbar configuration with Magento Media Gallery"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminAddImageToWYSIWYGCatalogTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToNewCatalog] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageNavigateToNewCatalog
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadNavigateToNewCatalog
		$I->comment("Exiting Action Group [navigateToNewCatalog] AdminOpenCategoryPageActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: wait2
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategory
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryWaitForPageLoad
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: enterCategoryName
		$I->click("//strong[contains(@class, 'admin__collapsible-title')]/span[text()='Content']"); // stepKey: clickContentTab
		$I->waitForElementVisible(".tox-tinymce", 30); // stepKey: waitForTinyMCE
		$I->scrollTo("button[title='Insert/edit image']"); // stepKey: scrollToImageIcon
		$I->waitForPageLoad(30); // stepKey: scrollToImageIconWaitForPageLoad
		$I->click("button[title='Insert/edit image']"); // stepKey: clickInsertImageIcon
		$I->waitForPageLoad(30); // stepKey: clickInsertImageIconWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
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
		$I->attachFile(".fileupload", "magento3.jpg"); // stepKey: uploadImageAttachImage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAttachImage1
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAttachImage1
		$I->waitForElementVisible("//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')]", 30); // stepKey: waitForUploadImageAttachImage1
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
		$I->attachFile(".fileupload", "magento3.jpg"); // stepKey: uploadImageAttachImage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAttachImage2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAttachImage2
		$I->waitForElementVisible("//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')]", 30); // stepKey: waitForUploadImageAttachImage2
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
		$I->comment("Entering Action Group [saveCatalog] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveCatalog
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveCatalogWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveCatalog
		$I->comment("Exiting Action Group [saveCatalog] AdminSaveCategoryActionGroup");
		$I->amOnPage("/simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: goToCategoryFrontPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->seeElement("img[alt='Image content. Yeah.']"); // stepKey: assertMediaDescription
		$I->seeElementInDOM("//img[contains(@src,'magento3')]"); // stepKey: assertMediaSource
	}
}
