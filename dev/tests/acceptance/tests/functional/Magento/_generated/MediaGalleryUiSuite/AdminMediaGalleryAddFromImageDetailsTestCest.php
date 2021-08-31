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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4569982: Adding image from the Image Details")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4569982")
 * @Description("Adding image from the Image Details<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminMediaGalleryAddFromImageDetailsTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryAddFromImageDetailsTestCest
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
		$I->comment("Entering Action Group [openNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageOpenNewPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadOpenNewPage
		$I->comment("Exiting Action Group [openNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryForPage] AdminOpenMediaGalleryFromPageNoEditorActionGroup");
		$I->conditionalClick("div[data-index=content]", "input[name=content_heading]", false); // stepKey: clickExpandContentOpenMediaGalleryForPage
		$I->waitForElementVisible(".scalable.action-add-image.plugin", 30); // stepKey: waitForInsertImageButtonOpenMediaGalleryForPage
		$I->scrollTo(".scalable.action-add-image.plugin", 0, -80); // stepKey: scrollToInsertImageButtonOpenMediaGalleryForPage
		$I->click(".scalable.action-add-image.plugin"); // stepKey: clickInsertImageOpenMediaGalleryForPage
		$I->comment("wait for initial media gallery load, where the gallery chrome loads (and triggers loading modal)");
		$I->waitForPageLoad(30); // stepKey: waitForMediaGalleryInitialLoadOpenMediaGalleryForPage
		$I->comment("wait for second media gallery load, where the gallery images load (and triggers loading modal once more)");
		$I->waitForPageLoad(30); // stepKey: waitForMediaGallerySecondaryLoadOpenMediaGalleryForPage
		$I->comment("Exiting Action Group [openMediaGalleryForPage] AdminOpenMediaGalleryFromPageNoEditorActionGroup");
		$I->comment("Entering Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadImage
		$I->attachFile("#image-uploader-input", "magento.jpg"); // stepKey: uploadImageUploadImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadImage
		$I->comment("Exiting Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/cms/page/new"); // stepKey: navigateToCreateNewPageOpenNewPage
		$I->waitForPageLoad(30); // stepKey: waitForNewPagePageLoadOpenNewPage
		$I->comment("Exiting Action Group [openNewPage] AdminOpenCreateNewCMSPageActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryForPage] AdminOpenMediaGalleryFromPageNoEditorActionGroup");
		$I->conditionalClick("div[data-index=content]", "input[name=content_heading]", false); // stepKey: clickExpandContentOpenMediaGalleryForPage
		$I->waitForElementVisible(".scalable.action-add-image.plugin", 30); // stepKey: waitForInsertImageButtonOpenMediaGalleryForPage
		$I->scrollTo(".scalable.action-add-image.plugin", 0, -80); // stepKey: scrollToInsertImageButtonOpenMediaGalleryForPage
		$I->click(".scalable.action-add-image.plugin"); // stepKey: clickInsertImageOpenMediaGalleryForPage
		$I->comment("wait for initial media gallery load, where the gallery chrome loads (and triggers loading modal)");
		$I->waitForPageLoad(30); // stepKey: waitForMediaGalleryInitialLoadOpenMediaGalleryForPage
		$I->comment("wait for second media gallery load, where the gallery images load (and triggers loading modal once more)");
		$I->waitForPageLoad(30); // stepKey: waitForMediaGallerySecondaryLoadOpenMediaGalleryForPage
		$I->comment("Exiting Action Group [openMediaGalleryForPage] AdminOpenMediaGalleryFromPageNoEditorActionGroup");
		$I->comment("Entering Action Group [viewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuViewImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsViewImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsViewImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearViewImageDetails
		$I->comment("Exiting Action Group [viewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
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
	 * @Stories({"[Story #38] User views basic image attributes in Media Gallery"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryAddFromImageDetailsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [viewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuViewImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsViewImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsViewImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearViewImageDetails
		$I->comment("Exiting Action Group [viewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [addImageFromViewDetails] AdminEnhancedMediaGalleryAddImageFromImageDetailsActionGroup");
		$I->click(".add-image-action"); // stepKey: openContextMenuAddImageFromViewDetails
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAddImageFromViewDetails
		$I->comment("Exiting Action Group [addImageFromViewDetails] AdminEnhancedMediaGalleryAddImageFromImageDetailsActionGroup");
		$I->comment("Entering Action Group [assertImageAddedToContent] AssertImageAddedToPageContentActionGroup");
		$grabTextFromContentAssertImageAddedToContent = $I->grabValueFrom("#cms_page_form_content"); // stepKey: grabTextFromContentAssertImageAddedToContent
		$I->assertStringContainsString("magento", $grabTextFromContentAssertImageAddedToContent); // stepKey: assertContentContainsAddedImageAssertImageAddedToContent
		$I->comment("Exiting Action Group [assertImageAddedToContent] AssertImageAddedToPageContentActionGroup");
	}
}
