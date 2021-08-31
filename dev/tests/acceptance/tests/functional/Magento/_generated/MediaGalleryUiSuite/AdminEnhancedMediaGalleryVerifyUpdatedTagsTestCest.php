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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1337102/scenarios/5064888: User checks if the deleted tags are removed from Edit page, Tags field")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1337102/scenarios/5064888")
 * @Description("User checks if changes made on the tags are updated from Edit page, Tags field<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminEnhancedMediaGalleryVerifyUpdatedTagsTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminEnhancedMediaGalleryVerifyUpdatedTagsTestCest
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
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteImage] AdminEnhancedMediaGalleryImageDetailsDeleteActionGroup");
		$I->click("//div[@class='media-gallery-image-details-modal']//button[contains(@class, 'delete')]"); // stepKey: deleteImageDeleteImage
		$I->waitForElementVisible(".action-accept", 30); // stepKey: waitForConfirmationDeleteImage
		$I->click(".action-accept"); // stepKey: confirmDeleteDeleteImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearDeleteImage
		$I->comment("Exiting Action Group [deleteImage] AdminEnhancedMediaGalleryImageDetailsDeleteActionGroup");
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
	 * @Stories({"User checks if the deleted tags are removed from Edit page, Tags field"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEnhancedMediaGalleryVerifyUpdatedTagsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadImage
		$I->attachFile("#image-uploader-input", "magento3.jpg"); // stepKey: uploadImageUploadImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadImage
		$I->comment("Exiting Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [viewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuViewImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsViewImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsViewImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearViewImageDetails
		$I->comment("Exiting Action Group [viewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [editImage] AdminEnhancedMediaGalleryImageDetailsEditActionGroup");
		$I->click("//div[@class='media-gallery-image-details-modal']//button[contains(@class, 'edit')]"); // stepKey: editImageEditImage
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-edit-image-details') and contains(@class, '_show')]//h1[contains(., 'Edit Image')]", 30); // stepKey: waitForLoadingMaskToDisappearEditImage
		$I->comment("Exiting Action Group [editImage] AdminEnhancedMediaGalleryImageDetailsEditActionGroup");
		$I->comment("Entering Action Group [setKeywords] AdminMediaGalleryEditAssetAddKeywordActionGroup");
		$I->fillField("[data-ui-id='keyword']", "newkeyword"); // stepKey: enterKeywordSetKeywords
		$I->click("[data-ui-id='add-keyword']"); // stepKey: addKeywordSetKeywords
		$I->comment("Exiting Action Group [setKeywords] AdminMediaGalleryEditAssetAddKeywordActionGroup");
		$I->comment("Entering Action Group [saveImage] AdminEnhancedMediaGalleryImageDetailsSaveActionGroup");
		$I->fillField("#title", "renamed title"); // stepKey: setTitleSaveImage
		$I->fillField("#description", "test description"); // stepKey: setDescriptionSaveImage
		$I->click("#image-details-action-save"); // stepKey: saveDetailsSaveImage
		$I->waitForPageLoad(30); // stepKey: saveDetailsSaveImageWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearSaveImage
		$I->comment("Exiting Action Group [saveImage] AdminEnhancedMediaGalleryImageDetailsSaveActionGroup");
		$I->comment("Entering Action Group [verifyAddedKeywords] AdminEnhancedMediaGalleryVerifyImageKeywordsActionGroup");
		$grabKeywordsVerifyAddedKeywords = $I->grabTextFrom("//div[@class='tags-list']"); // stepKey: grabKeywordsVerifyAddedKeywords
		$I->assertStringContainsString("newkeyword", $grabKeywordsVerifyAddedKeywords); // stepKey: verifyKeywordsVerifyAddedKeywords
		$I->comment("Exiting Action Group [verifyAddedKeywords] AdminEnhancedMediaGalleryVerifyImageKeywordsActionGroup");
		$I->comment("Entering Action Group [updateImageDetails] AdminEnhancedMediaGalleryImageDetailsEditActionGroup");
		$I->click("//div[@class='media-gallery-image-details-modal']//button[contains(@class, 'edit')]"); // stepKey: editImageUpdateImageDetails
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-edit-image-details') and contains(@class, '_show')]//h1[contains(., 'Edit Image')]", 30); // stepKey: waitForLoadingMaskToDisappearUpdateImageDetails
		$I->comment("Exiting Action Group [updateImageDetails] AdminEnhancedMediaGalleryImageDetailsEditActionGroup");
		$I->comment("Entering Action Group [removeKeywords] AdminMediaGalleryEditAssetRemoveKeywordActionGroup");
		$I->click("//span[contains(text(), 'newkeyword')]/following-sibling::button[@data-action='remove-selected-item']"); // stepKey: removeKeywordRemoveKeywords
		$I->comment("Exiting Action Group [removeKeywords] AdminMediaGalleryEditAssetRemoveKeywordActionGroup");
		$I->comment("Entering Action Group [saveUpdatedImage] AdminEnhancedMediaGalleryImageDetailsSaveActionGroup");
		$I->fillField("#title", "renamed title"); // stepKey: setTitleSaveUpdatedImage
		$I->fillField("#description", "test description"); // stepKey: setDescriptionSaveUpdatedImage
		$I->click("#image-details-action-save"); // stepKey: saveDetailsSaveUpdatedImage
		$I->waitForPageLoad(30); // stepKey: saveDetailsSaveUpdatedImageWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearSaveUpdatedImage
		$I->comment("Exiting Action Group [saveUpdatedImage] AdminEnhancedMediaGalleryImageDetailsSaveActionGroup");
		$I->comment("Entering Action Group [verifyRemovedKeywords] AssetAdminEnhancedMediaGalleryAssetDetailsKeywordsAbsentActionGroup");
		$grabKeywordsVerifyRemovedKeywords = $I->grabTextFrom("//div[@class='tags-list']"); // stepKey: grabKeywordsVerifyRemovedKeywords
		$I->assertStringNotContainsString("newkeyword", $grabKeywordsVerifyRemovedKeywords); // stepKey: verifyKeywordsVerifyRemovedKeywords
		$I->comment("Exiting Action Group [verifyRemovedKeywords] AssetAdminEnhancedMediaGalleryAssetDetailsKeywordsAbsentActionGroup");
	}
}
