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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1507933/scenarios/5200023: Admin user should see correct image file size after rendition")
 * @Description("Admin user should see correct image file size after rendition<h3>Test files</h3>app/code/Magento/MediaGalleryRenditions/Test/Mftf/Test/AdminMediaGalleryInsertImageLargeFileSizeTest.xml<br>")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1507933/scenarios/5200023")
 * @group media_gallery_ui
 */
class AdminMediaGalleryInsertImageLargeFileSizeTestCest
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
		$I->createEntity("category", "hook", "SimpleSubCategory", [], []); // stepKey: category
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteAllImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: openMediaGalleryPageDeleteAllImages
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllImages
		$I->conditionalClick("//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllImages
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllImagesWaitForPageLoad
		$I->comment('[deleteAllImagesUsingMassActionDeleteAllImages] Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper::deleteAllImagesUsingMassAction()');
		$this->helperContainer->get('Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper')->deleteAllImagesUsingMassAction("[data-id='media-gallery-masonry-grid'] .no-data-message-container", "#delete_massaction", "[data-id='media-gallery-masonry-grid'] .mediagallery-massaction-checkbox input[type='checkbox']", "#delete_selected_massaction", ".media-gallery-delete-image-action .action-accept", ".media-gallery-container ul.messages div.message.message-success span", "been successfully deleted"); // stepKey: deleteAllImagesUsingMassActionDeleteAllImages
		$I->comment("Exiting Action Group [deleteAllImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteAllImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery/media"); // stepKey: openMediaGalleryPageDeleteAllImages
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllImages
		$I->conditionalClick("//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='media-gallery-container']//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllImages
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllImagesWaitForPageLoad
		$I->comment('[deleteAllImagesUsingMassActionDeleteAllImages] Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper::deleteAllImagesUsingMassAction()');
		$this->helperContainer->get('Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper')->deleteAllImagesUsingMassAction("[data-id='media-gallery-masonry-grid'] .no-data-message-container", "#delete_massaction", "[data-id='media-gallery-masonry-grid'] .mediagallery-massaction-checkbox input[type='checkbox']", "#delete_selected_massaction", ".media-gallery-delete-image-action .action-accept", ".media-gallery-container ul.messages div.message.message-success span", "been successfully deleted"); // stepKey: deleteAllImagesUsingMassActionDeleteAllImages
		$I->comment("Exiting Action Group [deleteAllImages] AdminEnhancedMediaGalleryDeletedAllImagesActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryCategoryGridPage] AdminOpenCategoryGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery_catalog/category/index"); // stepKey: navigateToCategoryGridPageOpenMediaGalleryCategoryGridPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryCategoryGridPage
		$I->comment("Exiting Action Group [openMediaGalleryCategoryGridPage] AdminOpenCategoryGridPageActionGroup");
		$I->comment("Entering Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilters] ClearFiltersAdminDataGridActionGroup");
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
	 * @Features({"MediaGalleryRenditions"})
	 * @Stories({"User inserts image rendition to the content"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryInsertImageLargeFileSizeTest(AcceptanceTester $I)
	{
		$I->comment("Open category page");
		$I->comment("Entering Action Group [openCategoryPage] GoToAdminCategoryPageByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/edit/id/" . $I->retrieveEntityField('category', 'id', 'test') . "/"); // stepKey: amOnAdminCategoryPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCategoryPage
		$I->see($I->retrieveEntityField('category', 'id', 'test'), ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] GoToAdminCategoryPageByIdActionGroup");
		$I->comment("Add image to category from gallery");
		$I->comment("Entering Action Group [openMediaGallery] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Select from Gallery']", false); // stepKey: clickExpandContentOpenMediaGallery
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Select from Gallery']", 30); // stepKey: waitForSelectFromGalleryOpenMediaGallery
		$I->click("//*[@class='file-uploader-area']/label[text()='Select from Gallery']"); // stepKey: clickSelectFromGalleryOpenMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGallery
		$I->comment("Exiting Action Group [openMediaGallery] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->comment("Entering Action Group [clearGridFiltersAgain] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFiltersAgain
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFiltersAgainWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFiltersAgain] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [addCategoryImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedAddCategoryImage
		$I->attachFile("#image-uploader-input", "magento.jpg"); // stepKey: uploadImageAddCategoryImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddCategoryImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearAddCategoryImage
		$I->comment("Exiting Action Group [addCategoryImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [selectImage] AdminMediaGalleryClickImageInGridActionGroup");
		$I->waitForElementVisible("//li[@data-ui-id='title'and text()='magento']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']", 30); // stepKey: waitForImageToBeVisibleSelectImage
		$I->click("//li[@data-ui-id='title'and text()='magento']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']"); // stepKey: clickOnImageSelectImage
		$I->comment("Exiting Action Group [selectImage] AdminMediaGalleryClickImageInGridActionGroup");
		$I->comment("Entering Action Group [addSelected] AdminMediaGalleryClickAddSelectedActionGroup");
		$I->waitForElementVisible(".media-gallery-add-selected", 30); // stepKey: waitForAddSelectedButtonAddSelected
		$I->click(".media-gallery-add-selected"); // stepKey: ClickAddSelectedAddSelected
		$I->waitForPageLoad(30); // stepKey: waitForImageToBeAddedAddSelected
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskDisappearAddSelected
		$I->comment("Exiting Action Group [addSelected] AdminMediaGalleryClickAddSelectedActionGroup");
		$I->comment("Assert added image size");
		$I->comment("Entering Action Group [assertSize] AdminAssertImageUploadFileSizeThanActionGroup");
		$imageSizeAssertSize = $I->grabTextFrom(".file-uploader-meta"); // stepKey: imageSizeAssertSize
		$I->assertStringContainsString("26 KB", $imageSizeAssertSize); // stepKey: assertFileSizeAssertSize
		$I->comment("Exiting Action Group [assertSize] AdminAssertImageUploadFileSizeThanActionGroup");
	}
}
