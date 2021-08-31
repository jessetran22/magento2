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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1337102/scenarios/4760144: User filters images by source filter")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1337102/scenarios/4760144")
 * @Description("User filters images by source filter<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminMediaGalleryFilterImagesBySourceTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryFilterImagesBySourceTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [resetAdminDataGridToDefaultView] ResetAdminDataGridToDefaultViewActionGroup");
		$I->waitForElementVisible("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']", 30); // stepKey: waitForViewBookmarksResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: waitForViewBookmarksResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->click("div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: openViewBookmarksResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: openViewBookmarksResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->click("//div[contains(@class, 'admin__data-grid-action-bookmarks')]/ul/li/div/a[text() = 'Default View']"); // stepKey: selectDefaultGridViewResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: selectDefaultGridViewResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->see("Default View", "div.admin__data-grid-action-bookmarks button[data-bind='toggleCollapsible']"); // stepKey: seeDefaultViewSelectedResetAdminDataGridToDefaultView
		$I->waitForPageLoad(30); // stepKey: seeDefaultViewSelectedResetAdminDataGridToDefaultViewWaitForPageLoad
		$I->comment("Exiting Action Group [resetAdminDataGridToDefaultView] ResetAdminDataGridToDefaultViewActionGroup");
		$I->comment("Entering Action Group [viewContentImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->click(".three-dots"); // stepKey: openContextMenuViewContentImageDetails
		$I->click("//ul[@class='action-menu _active']//a[text()='View Details']"); // stepKey: viewDetailsViewContentImageDetails
		$I->waitForPageLoad(30); // stepKey: viewDetailsViewContentImageDetailsWaitForPageLoad
		$I->waitForElementVisible("//aside[contains(@class, 'media-gallery-image-details') and contains(@class, '_show')]//header[contains(@class, 'modal-header')]//h1[contains(@class, 'modal-title') and contains(., 'Image Details')]", 30); // stepKey: waitForLoadingMaskToDisappearViewContentImageDetails
		$I->comment("Exiting Action Group [viewContentImageDetails] AdminEnhancedMediaGalleryViewImageDetails");
		$I->comment("Entering Action Group [verifyImageDetails] AdminEnhancedMediaGalleryVerifyImageDetailsActionGroup");
		$grabImageTitleVerifyImageDetails = $I->grabTextFrom(".image-title"); // stepKey: grabImageTitleVerifyImageDetails
		$I->assertStringContainsString("magento", $grabImageTitleVerifyImageDetails); // stepKey: verifyImageTitleVerifyImageDetails
		$grabContentTypeVerifyImageDetails = $I->grabTextFrom("span[data-ui-id='content-type']"); // stepKey: grabContentTypeVerifyImageDetails
		$I->assertStringContainsStringIgnoringCase("jpg", $grabContentTypeVerifyImageDetails); // stepKey: verifyContentTypeVerifyImageDetails
		$grabTypeVerifyImageDetails = $I->grabTextFrom("//div[@class='attribute']/span[contains(text(), 'Type')]/following-sibling::div"); // stepKey: grabTypeVerifyImageDetails
		$I->assertStringContainsString("Image", $grabTypeVerifyImageDetails); // stepKey: verifyTypeVerifyImageDetails
		$I->comment("Exiting Action Group [verifyImageDetails] AdminEnhancedMediaGalleryVerifyImageDetailsActionGroup");
		$I->comment("Entering Action Group [deleteContentImage] AdminEnhancedMediaGalleryImageDetailsDeleteActionGroup");
		$I->click("//div[@class='media-gallery-image-details-modal']//button[contains(@class, 'delete')]"); // stepKey: deleteImageDeleteContentImage
		$I->waitForElementVisible(".action-accept", 30); // stepKey: waitForConfirmationDeleteContentImage
		$I->click(".action-accept"); // stepKey: confirmDeleteDeleteContentImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearDeleteContentImage
		$I->comment("Exiting Action Group [deleteContentImage] AdminEnhancedMediaGalleryImageDetailsDeleteActionGroup");
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
	public function AdminMediaGalleryFilterImagesBySourceTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openStandaloneMediaGalleryPage] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: amOnStandaloneMediaGalleryPageOpenStandaloneMediaGalleryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenStandaloneMediaGalleryPage
		$I->comment("Exiting Action Group [openStandaloneMediaGalleryPage] AdminOpenStandaloneMediaGalleryActionGroup");
		$I->comment("Entering Action Group [uploadContentImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadContentImage
		$I->attachFile("#image-uploader-input", "magento3.jpg"); // stepKey: uploadImageUploadContentImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadContentImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadContentImage
		$I->comment("Exiting Action Group [uploadContentImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-expand']"); // stepKey: expandFilterExpandFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearExpandFilters
		$I->comment("Exiting Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->comment("Entering Action Group [applyLocalFilter] AdminEnhancedMediaGallerySelectSourceFilterActionGroup");
		$I->click("//div[@class='media-gallery-container']//select[@name='source']//option[@value='Local']"); // stepKey: openContextMenuApplyLocalFilter
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearApplyLocalFilter
		$I->comment("Exiting Action Group [applyLocalFilter] AdminEnhancedMediaGallerySelectSourceFilterActionGroup");
		$I->comment("Entering Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearApplyFilters
		$I->comment("Exiting Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->comment("Entering Action Group [assertImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
		$I->waitForElementVisible("//li[@data-ui-id='title'and text()='Title of the magento image']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']", 30); // stepKey: waitForImageToBeVisibleAssertImageInGrid
		$I->comment("Exiting Action Group [assertImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
	}
}
