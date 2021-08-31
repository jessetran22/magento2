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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/3961351: Editing an image from view details panel")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/3961351")
 * @Description("Editing an image from view details panel<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminMediaGalleryViewDetailsEditTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryViewDetailsEditTestCest
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
	 * @Stories({"[Story #44] User edits image meta data in Media Gallery"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryViewDetailsEditTest(AcceptanceTester $I)
	{
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
		$I->comment("Entering Action Group [editImage] AdminEnhancedMediaGalleryImageDetailsEditActionGroup");
		$I->click("//div[@class='media-gallery-image-details-modal']//button[contains(@class, 'edit')]"); // stepKey: editImageEditImage
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-edit-image-details') and contains(@class, '_show')]//h1[contains(., 'Edit Image')]", 30); // stepKey: waitForLoadingMaskToDisappearEditImage
		$I->comment("Exiting Action Group [editImage] AdminEnhancedMediaGalleryImageDetailsEditActionGroup");
		$I->comment("Entering Action Group [saveImage] AdminEnhancedMediaGalleryImageDetailsSaveActionGroup");
		$I->fillField("#title", "renamed title"); // stepKey: setTitleSaveImage
		$I->fillField("#description", "test description"); // stepKey: setDescriptionSaveImage
		$I->click("#image-details-action-save"); // stepKey: saveDetailsSaveImage
		$I->waitForPageLoad(30); // stepKey: saveDetailsSaveImageWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearSaveImage
		$I->comment("Exiting Action Group [saveImage] AdminEnhancedMediaGalleryImageDetailsSaveActionGroup");
		$I->comment("Entering Action Group [verifyUpdateImageOnTheGrid] AssertImageAttributesOnEnhancedMediaGalleryActionGroup");
		$grabImageTitleVerifyUpdateImageOnTheGrid = $I->grabTextFrom(".masonry-image-description .name"); // stepKey: grabImageTitleVerifyUpdateImageOnTheGrid
		$I->assertStringContainsString("renamed title", $grabImageTitleVerifyUpdateImageOnTheGrid); // stepKey: verifyImageTitleVerifyUpdateImageOnTheGrid
		$grabContentTypeVerifyUpdateImageOnTheGrid = $I->grabTextFrom(".masonry-image-description .type"); // stepKey: grabContentTypeVerifyUpdateImageOnTheGrid
		$I->assertStringContainsStringIgnoringCase("jpg", $grabContentTypeVerifyUpdateImageOnTheGrid); // stepKey: verifyContentTypeVerifyUpdateImageOnTheGrid
		$grabDimensionsVerifyUpdateImageOnTheGrid = $I->grabTextFrom(".masonry-image-description .dimensions"); // stepKey: grabDimensionsVerifyUpdateImageOnTheGrid
		$I->assertNotEmpty($grabDimensionsVerifyUpdateImageOnTheGrid); // stepKey: verifyDimensionsVerifyUpdateImageOnTheGrid
		$I->comment("Exiting Action Group [verifyUpdateImageOnTheGrid] AssertImageAttributesOnEnhancedMediaGalleryActionGroup");
		$I->comment("Entering Action Group [verifyImageDetails] AdminEnhancedMediaGalleryVerifyImageDetailsActionGroup");
		$grabImageTitleVerifyImageDetails = $I->grabTextFrom(".image-title"); // stepKey: grabImageTitleVerifyImageDetails
		$I->assertStringContainsString("renamed title", $grabImageTitleVerifyImageDetails); // stepKey: verifyImageTitleVerifyImageDetails
		$grabContentTypeVerifyImageDetails = $I->grabTextFrom("span[data-ui-id='content-type']"); // stepKey: grabContentTypeVerifyImageDetails
		$I->assertStringContainsStringIgnoringCase("jpg", $grabContentTypeVerifyImageDetails); // stepKey: verifyContentTypeVerifyImageDetails
		$grabTypeVerifyImageDetails = $I->grabTextFrom("//div[@class='attribute']/span[contains(text(), 'Type')]/following-sibling::div"); // stepKey: grabTypeVerifyImageDetails
		$I->assertStringContainsString("Image", $grabTypeVerifyImageDetails); // stepKey: verifyTypeVerifyImageDetails
		$I->comment("Exiting Action Group [verifyImageDetails] AdminEnhancedMediaGalleryVerifyImageDetailsActionGroup");
		$I->comment("Entering Action Group [verifyImageDescription] AdminEnhancedMediaGalleryVerifyImageDescriptionActionGroup");
		$grabDescriptionVerifyImageDescription = $I->grabTextFrom(".image-details-section.description p"); // stepKey: grabDescriptionVerifyImageDescription
		$I->assertStringContainsString("test description", $grabDescriptionVerifyImageDescription); // stepKey: verifyDescriptionVerifyImageDescription
		$I->comment("Exiting Action Group [verifyImageDescription] AdminEnhancedMediaGalleryVerifyImageDescriptionActionGroup");
	}
}
