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
 * @Title("MC-13832: MC-5784: Image fields using imageUploader UIComponent cannot use gallery image")
 * @Description("Admin should be able to use Image Uploader to add Gallery Images<h3>Test files</h3>app/code/Magento/Theme/Test/Mftf/Test/AdminDesignConfigMediaGalleryImageUploadTest.xml<br>")
 * @TestCaseId("MC-13832")
 * @group Content
 */
class AdminDesignConfigMediaGalleryImageUploadTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginToAdminArea] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminArea
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminArea
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminArea
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminArea
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminAreaWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminArea
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminArea
		$I->comment("Exiting Action Group [loginToAdminArea] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Theme"})
	 * @Stories({"Content"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDesignConfigMediaGalleryImageUploadTest(AcceptanceTester $I)
	{
		$I->comment("Edit Store View");
		$I->comment("Edit Store View");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/theme/design_config/"); // stepKey: navigateToDesignConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForPageload1
		$I->click("//*[contains(@class,'data-row')][3]//*[contains(@class,'action-menu-item')]"); // stepKey: editStoreView
		$I->waitForPageLoad(30); // stepKey: waitForPageload2
		$I->scrollTo("[data-index='head']"); // stepKey: scrollToHtmlHeadSection
		$I->click("[data-index='head']"); // stepKey: openHtmlHeadSection
		$I->comment("Upload Image");
		$I->comment("Upload Image");
		$I->click("//*[contains(@class,'fieldset-wrapper')][child::*[contains(@class,'fieldset-wrapper-title')]//*[contains(text(),'Head')]]//*[contains(@class,'file-uploader')]//label[contains(text(), 'Select from Gallery')]"); // stepKey: openMediaGallery
		$I->comment("Entering Action Group [verifyMediaGalleryStorageBtn] VerifyMediaGalleryStorageActionsActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1VerifyMediaGalleryStorageBtn
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading1VerifyMediaGalleryStorageBtn
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoading2VerifyMediaGalleryStorageBtn
		$I->see("Cancel", "#cancel"); // stepKey: seeCancelBtnVerifyMediaGalleryStorageBtn
		$I->see("Create Folder", "#new_folder"); // stepKey: seeCreateFolderBtnVerifyMediaGalleryStorageBtn
		$I->waitForPageLoad(30); // stepKey: seeCreateFolderBtnVerifyMediaGalleryStorageBtnWaitForPageLoad
		$I->comment("Exiting Action Group [verifyMediaGalleryStorageBtn] VerifyMediaGalleryStorageActionsActionGroup");
		$I->comment("Entering Action Group [navigateToFolder] NavigateToMediaFolderActionGroup");
		$I->conditionalClick("#root > .jstree-icon", "//li[@id='root' and contains(@class,'jstree-closed')]", true); // stepKey: clickArrowIfClosedNavigateToFolder
		$I->waitForPageLoad(10); // stepKey: waitForDirectoriesTreeBuildingNavigateToFolder
		$I->waitForText("Storage Root", 30); // stepKey: waitForNewFolderNavigateToFolder
		$I->click("Storage Root"); // stepKey: clickOnCreatedFolderNavigateToFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingNavigateToFolder
		$I->comment("Exiting Action Group [navigateToFolder] NavigateToMediaFolderActionGroup");
		$I->comment("Entering Action Group [selectImageFromMediaStorage] AttachImageActionGroup");
		$I->attachFile(".fileupload", "magento3.jpg"); // stepKey: uploadImageSelectImageFromMediaStorage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectImageFromMediaStorage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearSelectImageFromMediaStorage
		$I->waitForElementVisible("//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')]", 30); // stepKey: waitForUploadImageSelectImageFromMediaStorage
		$I->comment("Exiting Action Group [selectImageFromMediaStorage] AttachImageActionGroup");
		$I->comment("Entering Action Group [insertImage] SaveImageActionGroup");
		$I->click("#insert_files"); // stepKey: clickInsertBtnInsertImage
		$I->waitForPageLoad(30); // stepKey: clickInsertBtnInsertImageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadInsertImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearInsertImage
		$I->comment("Exiting Action Group [insertImage] SaveImageActionGroup");
		$I->click("//button[contains(@title, 'Save Configuration')]"); // stepKey: saveConfiguration
		$I->waitForElementVisible("//div[contains(@data-ui-id, 'messages-message-success')]", 30); // stepKey: waitForSuccessNotification
		$I->waitForPageLoad(30); // stepKey: waitForPageloadSuccess
		$I->comment("Edit Store View");
		$I->comment("Edit Store View");
		$I->click("//*[contains(@class,'data-row')][3]//*[contains(@class,'action-menu-item')]"); // stepKey: editStoreView2
		$I->waitForPageLoad(30); // stepKey: waitForPageload3
		$I->scrollTo("[data-index='head']"); // stepKey: scrollToHtmlHeadSection2
		$I->click("[data-index='head']"); // stepKey: openHtmlHeadSection2
		$I->comment("Save Default Configuration");
		$I->comment("Save Default Configuration");
		$I->click("//*[contains(@class,'fieldset-wrapper')][child::*[contains(@class,'fieldset-wrapper-title')]//*[contains(text(),'Head')]]//*[contains(@class,'file-uploader')]//span[contains(text(), 'Use Default Value')]"); // stepKey: clickUseDefault
		$I->waitForElementVisible("//button[contains(@title, 'Save Configuration')]", 30); // stepKey: waitForWrapperToClose2
		$I->click("//button[contains(@title, 'Save Configuration')]"); // stepKey: saveConfiguration2
		$I->waitForElementVisible("//div[contains(@data-ui-id, 'messages-message-success')]", 30); // stepKey: waitForSuccessNotification2
		$I->waitForPageLoad(30); // stepKey: waitForPageloadSuccess2
		$I->comment("Delete Image: will be in both root and favicon");
		$I->comment("Delete Image");
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
		$I->comment("Entering Action Group [navigateToFolder2] NavigateToMediaFolderActionGroup");
		$I->conditionalClick("#root > .jstree-icon", "//li[@id='root' and contains(@class,'jstree-closed')]", true); // stepKey: clickArrowIfClosedNavigateToFolder2
		$I->waitForPageLoad(10); // stepKey: waitForDirectoriesTreeBuildingNavigateToFolder2
		$I->waitForText("Storage Root", 30); // stepKey: waitForNewFolderNavigateToFolder2
		$I->click("Storage Root"); // stepKey: clickOnCreatedFolderNavigateToFolder2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingNavigateToFolder2
		$I->comment("Exiting Action Group [navigateToFolder2] NavigateToMediaFolderActionGroup");
		$I->comment("Entering Action Group [deleteImageFromStorage] DeleteImageFromStorageActionGroup");
		$I->waitForElementVisible("//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')]", 30); // stepKey: waitForInitialImagesDeleteImageFromStorage
		$initialImagesDeleteImageFromStorage = $I->grabMultiple("//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')]"); // stepKey: initialImagesDeleteImageFromStorage
		$I->waitForElementVisible("(//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')])[last()]", 30); // stepKey: waitForLastImageDeleteImageFromStorage
		$I->click("(//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')])[last()]"); // stepKey: selectImageDeleteImageFromStorage
		$I->waitForElementVisible("#delete_files", 30); // stepKey: waitForDeleteBtnDeleteImageFromStorage
		$I->waitForPageLoad(30); // stepKey: waitForDeleteBtnDeleteImageFromStorageWaitForPageLoad
		$I->click("#delete_files"); // stepKey: clickDeleteSelectedDeleteImageFromStorage
		$I->waitForPageLoad(30); // stepKey: clickDeleteSelectedDeleteImageFromStorageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeleteImageFromStorage
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForConfirmBtnDeleteImageFromStorage
		$I->click(".action-primary.action-accept"); // stepKey: clickConfirmBtnDeleteImageFromStorage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteImageFromStorage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearDeleteImageFromStorage
		$newImagesDeleteImageFromStorage = $I->grabMultiple("//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')]"); // stepKey: newImagesDeleteImageFromStorage
		$I->assertLessThan($initialImagesDeleteImageFromStorage, $newImagesDeleteImageFromStorage); // stepKey: assertLessImagesDeleteImageFromStorage
		$I->comment("Exiting Action Group [deleteImageFromStorage] DeleteImageFromStorageActionGroup");
		$I->comment("Entering Action Group [navigateToFolder3] NavigateToFaviconMediaFolderActionGroup");
		$I->conditionalClick("#root > .jstree-icon", "//li[@id='root' and contains(@class,'jstree-closed')]", true); // stepKey: clickArrowIfClosedNavigateToFolder3
		$I->waitForElement("#ZmF2aWNvbg-- > .jstree-icon", 30); // stepKey: waitForFaviconFolderNavigateToFolder3
		$I->conditionalClick("#ZmF2aWNvbg-- > .jstree-icon", "//li[@id='ZmF2aWNvbg--' and contains(@class,'jstree-closed')]", true); // stepKey: clickFaviconArrowIfClosedNavigateToFolder3
		$I->waitForElement("#ZmF2aWNvbi9zdG9yZXM- > .jstree-icon", 30); // stepKey: waitForStoresFolderNavigateToFolder3
		$I->conditionalClick("#ZmF2aWNvbi9zdG9yZXM- > .jstree-icon", "//li[@id='ZmF2aWNvbi9zdG9yZXM-' and contains(@class,'jstree-closed')]", true); // stepKey: clickStoresArrowIfClosedNavigateToFolder3
		$I->waitForElement("#ZmF2aWNvbi9zdG9yZXMvMQ-- > a", 30); // stepKey: waitForStoreFolderNavigateToFolder3
		$I->click("#ZmF2aWNvbi9zdG9yZXMvMQ-- > a"); // stepKey: clickOnCreatedFolderNavigateToFolder3
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingNavigateToFolder3
		$I->comment("Exiting Action Group [navigateToFolder3] NavigateToFaviconMediaFolderActionGroup");
		$I->comment("Entering Action Group [deleteImageFromStorage2] DeleteImageFromStorageActionGroup");
		$I->waitForElementVisible("//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')]", 30); // stepKey: waitForInitialImagesDeleteImageFromStorage2
		$initialImagesDeleteImageFromStorage2 = $I->grabMultiple("//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')]"); // stepKey: initialImagesDeleteImageFromStorage2
		$I->waitForElementVisible("(//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')])[last()]", 30); // stepKey: waitForLastImageDeleteImageFromStorage2
		$I->click("(//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')])[last()]"); // stepKey: selectImageDeleteImageFromStorage2
		$I->waitForElementVisible("#delete_files", 30); // stepKey: waitForDeleteBtnDeleteImageFromStorage2
		$I->waitForPageLoad(30); // stepKey: waitForDeleteBtnDeleteImageFromStorage2WaitForPageLoad
		$I->click("#delete_files"); // stepKey: clickDeleteSelectedDeleteImageFromStorage2
		$I->waitForPageLoad(30); // stepKey: clickDeleteSelectedDeleteImageFromStorage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1DeleteImageFromStorage2
		$I->waitForElementVisible(".action-primary.action-accept", 30); // stepKey: waitForConfirmBtnDeleteImageFromStorage2
		$I->click(".action-primary.action-accept"); // stepKey: clickConfirmBtnDeleteImageFromStorage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2DeleteImageFromStorage2
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearDeleteImageFromStorage2
		$newImagesDeleteImageFromStorage2 = $I->grabMultiple("//div[contains(@class,'media-gallery-modal')]//img[contains(@alt, 'magento3.jpg')]|//img[contains(@alt,'magento3_') and contains(@alt,'.jpg')]"); // stepKey: newImagesDeleteImageFromStorage2
		$I->assertLessThan($initialImagesDeleteImageFromStorage2, $newImagesDeleteImageFromStorage2); // stepKey: assertLessImagesDeleteImageFromStorage2
		$I->comment("Exiting Action Group [deleteImageFromStorage2] DeleteImageFromStorageActionGroup");
	}
}
