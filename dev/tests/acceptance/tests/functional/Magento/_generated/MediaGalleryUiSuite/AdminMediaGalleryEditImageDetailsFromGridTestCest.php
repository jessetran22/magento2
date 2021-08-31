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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/3961351: User edits image meta data in media gallery")
 * @Description("User edits image meta data in Standalone Media Gallery<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminMediaGalleryEditImageDetailsFromGridTest.xml<br>")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1320712/scenarios/3961351")
 * @group media_gallery_ui
 */
class AdminMediaGalleryEditImageDetailsFromGridTestCest
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
		$I->comment("Entering Action Group [deleteAllMediaGalleryImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: openMediaGalleryPageDeleteAllMediaGalleryImages
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllMediaGalleryImages
		$I->conditionalClick("//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllMediaGalleryImages
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllMediaGalleryImagesWaitForPageLoad
		$I->comment('[deleteAllImagesUsingMassActionDeleteAllMediaGalleryImages] Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper::deleteAllImagesUsingMassAction()');
		$this->helperContainer->get('Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper')->deleteAllImagesUsingMassAction("[data-id='media-gallery-masonry-grid'] .no-data-message-container", "#delete_massaction", "[data-id='media-gallery-masonry-grid'] .mediagallery-massaction-checkbox input[type='checkbox']", "#delete_selected_massaction", ".media-gallery-delete-image-action .action-accept", ".media-gallery-container ul.messages div.message.message-success span", "been successfully deleted"); // stepKey: deleteAllImagesUsingMassActionDeleteAllMediaGalleryImages
		$I->comment("Exiting Action Group [deleteAllMediaGalleryImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteAllMediaGalleryImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: openMediaGalleryPageDeleteAllMediaGalleryImages
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllMediaGalleryImages
		$I->conditionalClick("//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllMediaGalleryImages
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllMediaGalleryImagesWaitForPageLoad
		$I->comment('[deleteAllImagesUsingMassActionDeleteAllMediaGalleryImages] Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper::deleteAllImagesUsingMassAction()');
		$this->helperContainer->get('Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper')->deleteAllImagesUsingMassAction("[data-id='media-gallery-masonry-grid'] .no-data-message-container", "#delete_massaction", "[data-id='media-gallery-masonry-grid'] .mediagallery-massaction-checkbox input[type='checkbox']", "#delete_selected_massaction", ".media-gallery-delete-image-action .action-accept", ".media-gallery-container ul.messages div.message.message-success span", "been successfully deleted"); // stepKey: deleteAllImagesUsingMassActionDeleteAllMediaGalleryImages
		$I->comment("Exiting Action Group [deleteAllMediaGalleryImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	 * @Stories({"[Story # 38] User views basic image attributes in Media Gallery"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryEditImageDetailsFromGridTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGallery
		$I->comment("Exiting Action Group [openStandaloneMediaGallery] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [resetMediaGalleryGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetMediaGalleryGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetMediaGalleryGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [resetMediaGalleryGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadImage
		$I->attachFile("#image-uploader-input", "magento.jpg"); // stepKey: uploadImageUploadImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadImage
		$I->comment("Exiting Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [editImageDetails] AdminEnhancedMediaGalleryEditImageDetailsActionGroup");
		$I->click(".three-dots"); // stepKey: openContextMenuEditImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='Edit']"); // stepKey: editEditImageDetails
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearEditImageDetails
		$I->comment("Exiting Action Group [editImageDetails] AdminEnhancedMediaGalleryEditImageDetailsActionGroup");
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
		$I->comment("Entering Action Group [viewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuViewImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsViewImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsViewImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearViewImageDetails
		$I->comment("Exiting Action Group [viewImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
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
