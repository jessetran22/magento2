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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4653671: Magento extracts image meta data from file")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4653671")
 * @Description("Magento extracts image meta data from file<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminEnhancedMediaGalleryUploadImageWithMetadataTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminEnhancedMediaGalleryUploadImageWithMetadataTestCest
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
	 * @Stories({"Story 53 - Magento extracts image meta data from file"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEnhancedMediaGalleryUploadImageWithMetadataTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [verifyImageDescription] AdminEnhancedMediaGalleryVerifyImageDescriptionActionGroup");
		$grabDescriptionVerifyImageDescription = $I->grabTextFrom(".image-details-section.description p"); // stepKey: grabDescriptionVerifyImageDescription
		$I->assertStringContainsString("Description of the magento image", $grabDescriptionVerifyImageDescription); // stepKey: verifyDescriptionVerifyImageDescription
		$I->comment("Exiting Action Group [verifyImageDescription] AdminEnhancedMediaGalleryVerifyImageDescriptionActionGroup");
		$I->comment("Entering Action Group [verifyImageKeywords] AdminEnhancedMediaGalleryVerifyImageKeywordsActionGroup");
		$grabKeywordsVerifyImageKeywords = $I->grabTextFrom("//div[@class='tags-list']"); // stepKey: grabKeywordsVerifyImageKeywords
		$I->assertStringContainsString("magento, mediagallerymetadata", $grabKeywordsVerifyImageKeywords); // stepKey: verifyKeywordsVerifyImageKeywords
		$I->comment("Exiting Action Group [verifyImageKeywords] AdminEnhancedMediaGalleryVerifyImageKeywordsActionGroup");
		$I->comment("Entering Action Group [verifyImageTitle] AdminEnhancedMediaGalleryVerifyImageTitleActionGroup");
		$grabImageTitleVerifyImageTitle = $I->grabTextFrom(".image-title"); // stepKey: grabImageTitleVerifyImageTitle
		$I->assertStringContainsString("Title of the magento image", $grabImageTitleVerifyImageTitle); // stepKey: verifyImageTitleVerifyImageTitle
		$I->comment("Exiting Action Group [verifyImageTitle] AdminEnhancedMediaGalleryVerifyImageTitleActionGroup");
		$I->comment("Entering Action Group [deleteJpegImage] AdminEnhancedMediaGalleryImageDetailsDeleteActionGroup");
		$I->click("//div[@class='media-gallery-image-details-modal']//button[contains(@class, 'delete')]"); // stepKey: deleteImageDeleteJpegImage
		$I->waitForElementVisible(".action-accept", 30); // stepKey: waitForConfirmationDeleteJpegImage
		$I->click(".action-accept"); // stepKey: confirmDeleteDeleteJpegImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearDeleteJpegImage
		$I->comment("Exiting Action Group [deleteJpegImage] AdminEnhancedMediaGalleryImageDetailsDeleteActionGroup");
		$I->comment("Entering Action Group [uploadPngImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadPngImage
		$I->attachFile("#image-uploader-input", "png.png"); // stepKey: uploadImageUploadPngImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadPngImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadPngImage
		$I->comment("Exiting Action Group [uploadPngImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [viewPngImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuViewPngImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsViewPngImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsViewPngImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearViewPngImageDetails
		$I->comment("Exiting Action Group [viewPngImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [verifyPngImageDescription] AdminEnhancedMediaGalleryVerifyImageDescriptionActionGroup");
		$grabDescriptionVerifyPngImageDescription = $I->grabTextFrom(".image-details-section.description p"); // stepKey: grabDescriptionVerifyPngImageDescription
		$I->assertStringContainsString("Description of the magento image", $grabDescriptionVerifyPngImageDescription); // stepKey: verifyDescriptionVerifyPngImageDescription
		$I->comment("Exiting Action Group [verifyPngImageDescription] AdminEnhancedMediaGalleryVerifyImageDescriptionActionGroup");
		$I->comment("Entering Action Group [verifyPngImageKeywords] AdminEnhancedMediaGalleryVerifyImageKeywordsActionGroup");
		$grabKeywordsVerifyPngImageKeywords = $I->grabTextFrom("//div[@class='tags-list']"); // stepKey: grabKeywordsVerifyPngImageKeywords
		$I->assertStringContainsString("magento, mediagallerymetadata", $grabKeywordsVerifyPngImageKeywords); // stepKey: verifyKeywordsVerifyPngImageKeywords
		$I->comment("Exiting Action Group [verifyPngImageKeywords] AdminEnhancedMediaGalleryVerifyImageKeywordsActionGroup");
		$I->comment("Entering Action Group [verifyPngImageTitle] AdminEnhancedMediaGalleryVerifyImageTitleActionGroup");
		$grabImageTitleVerifyPngImageTitle = $I->grabTextFrom(".image-title"); // stepKey: grabImageTitleVerifyPngImageTitle
		$I->assertStringContainsString("Title of the magento image", $grabImageTitleVerifyPngImageTitle); // stepKey: verifyImageTitleVerifyPngImageTitle
		$I->comment("Exiting Action Group [verifyPngImageTitle] AdminEnhancedMediaGalleryVerifyImageTitleActionGroup");
		$I->comment("Entering Action Group [deletePngImage] AdminEnhancedMediaGalleryImageDetailsDeleteActionGroup");
		$I->click("//div[@class='media-gallery-image-details-modal']//button[contains(@class, 'delete')]"); // stepKey: deleteImageDeletePngImage
		$I->waitForElementVisible(".action-accept", 30); // stepKey: waitForConfirmationDeletePngImage
		$I->click(".action-accept"); // stepKey: confirmDeleteDeletePngImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearDeletePngImage
		$I->comment("Exiting Action Group [deletePngImage] AdminEnhancedMediaGalleryImageDetailsDeleteActionGroup");
		$I->comment("Entering Action Group [uploadGifImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadGifImage
		$I->attachFile("#image-uploader-input", "gif.gif"); // stepKey: uploadImageUploadGifImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadGifImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadGifImage
		$I->comment("Exiting Action Group [uploadGifImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [viewGifImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuViewGifImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsViewGifImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsViewGifImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearViewGifImageDetails
		$I->comment("Exiting Action Group [viewGifImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [verifyGifImageDescription] AdminEnhancedMediaGalleryVerifyImageDescriptionActionGroup");
		$grabDescriptionVerifyGifImageDescription = $I->grabTextFrom(".image-details-section.description p"); // stepKey: grabDescriptionVerifyGifImageDescription
		$I->assertStringContainsString("Description of the magento image", $grabDescriptionVerifyGifImageDescription); // stepKey: verifyDescriptionVerifyGifImageDescription
		$I->comment("Exiting Action Group [verifyGifImageDescription] AdminEnhancedMediaGalleryVerifyImageDescriptionActionGroup");
		$I->comment("Entering Action Group [verifyGifImageKeywords] AdminEnhancedMediaGalleryVerifyImageKeywordsActionGroup");
		$grabKeywordsVerifyGifImageKeywords = $I->grabTextFrom("//div[@class='tags-list']"); // stepKey: grabKeywordsVerifyGifImageKeywords
		$I->assertStringContainsString("magento, mediagallerymetadata", $grabKeywordsVerifyGifImageKeywords); // stepKey: verifyKeywordsVerifyGifImageKeywords
		$I->comment("Exiting Action Group [verifyGifImageKeywords] AdminEnhancedMediaGalleryVerifyImageKeywordsActionGroup");
		$I->comment("Entering Action Group [verifyGifImageTitle] AdminEnhancedMediaGalleryVerifyImageTitleActionGroup");
		$grabImageTitleVerifyGifImageTitle = $I->grabTextFrom(".image-title"); // stepKey: grabImageTitleVerifyGifImageTitle
		$I->assertStringContainsString("Title of the magento image", $grabImageTitleVerifyGifImageTitle); // stepKey: verifyImageTitleVerifyGifImageTitle
		$I->comment("Exiting Action Group [verifyGifImageTitle] AdminEnhancedMediaGalleryVerifyImageTitleActionGroup");
		$I->comment("Entering Action Group [deleteGifImage] AdminEnhancedMediaGalleryImageDetailsDeleteActionGroup");
		$I->click("//div[@class='media-gallery-image-details-modal']//button[contains(@class, 'delete')]"); // stepKey: deleteImageDeleteGifImage
		$I->waitForElementVisible(".action-accept", 30); // stepKey: waitForConfirmationDeleteGifImage
		$I->click(".action-accept"); // stepKey: confirmDeleteDeleteGifImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearDeleteGifImage
		$I->comment("Exiting Action Group [deleteGifImage] AdminEnhancedMediaGalleryImageDetailsDeleteActionGroup");
	}
}
