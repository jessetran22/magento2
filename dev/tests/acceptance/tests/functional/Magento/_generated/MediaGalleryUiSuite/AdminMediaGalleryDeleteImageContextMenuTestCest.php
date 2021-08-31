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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4753539: Uploading and deleting an image using context menu")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4753539")
 * @Description("Uploading and deleting an image using context menu<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminMediaGalleryDeleteImageContextMenuTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryDeleteImageContextMenuTestCest
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
	 * @Stories({"[Story #52] User accesses Media Gallery from the main navigation"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryDeleteImageContextMenuTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadImage
		$I->attachFile("#image-uploader-input", "magento3.jpg"); // stepKey: uploadImageUploadImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadImage
		$I->comment("Exiting Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [deleteImage] AdminEnhancedMediaGalleryImageDeleteActionGroup");
		$I->click(".three-dots"); // stepKey: openContextMenuDeleteImage
		$I->click("//ul[@class='action-menu _active']//a[text()='Delete']"); // stepKey: deleteImageDeleteImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeleteModalDeleteImage
		$I->click(".media-gallery-delete-image-action .action-accept"); // stepKey: confirmDeleteDeleteImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearDeleteImage
		$I->comment("Exiting Action Group [deleteImage] AdminEnhancedMediaGalleryImageDeleteActionGroup");
		$I->comment("Entering Action Group [assertImageDeleted] AssertAdminEnhancedMediaGalleryImageDeletedActionGroup");
		$I->see("The asset \"Title of the magento image\" has been successfully deleted"); // stepKey: verifyDeleteImageAssertImageDeleted
		$I->comment("Exiting Action Group [assertImageDeleted] AssertAdminEnhancedMediaGalleryImageDeletedActionGroup");
	}
}
