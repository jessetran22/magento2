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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4753539: User can filter duplicated images")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4753539")
 * @Description("User can filter duplicated images<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminEnhancedMediaGalleryDuplicatedImagesTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminEnhancedMediaGalleryDuplicatedImagesTestCest
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
		$I->comment("Entering Action Group [enableMassActionToDeleteImages] AdminEnhancedMediaGalleryEnableMassActionModeActionGroup");
		$I->wait(5); // stepKey: waitBeforeEnableMassActionToDeleteImages
		$I->waitForElementVisible("#delete_massaction", 30); // stepKey: waitForMassActionButtonEnableMassActionToDeleteImages
		$I->click("#delete_massaction"); // stepKey: clickOnMassActionButtonEnableMassActionToDeleteImages
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedEnableMassActionToDeleteImages
		$I->wait(5); // stepKey: waitAfterEnableMassActionToDeleteImages
		$I->comment("Exiting Action Group [enableMassActionToDeleteImages] AdminEnhancedMediaGalleryEnableMassActionModeActionGroup");
		$I->comment("Entering Action Group [selectFirstImageToDelete] AdminEnhancedMediaGallerySelectImageForMassActionActionGroup");
		$I->checkOption("//input[@type='checkbox'][@data-ui-id ='magento']"); // stepKey: selectImageInGridToDelteSelectFirstImageToDelete
		$I->comment("Exiting Action Group [selectFirstImageToDelete] AdminEnhancedMediaGallerySelectImageForMassActionActionGroup");
		$I->comment("Entering Action Group [selectSecondImageToDelete] AdminEnhancedMediaGallerySelectImageForMassActionActionGroup");
		$I->checkOption("//input[@type='checkbox'][@data-ui-id ='magento-again']"); // stepKey: selectImageInGridToDelteSelectSecondImageToDelete
		$I->comment("Exiting Action Group [selectSecondImageToDelete] AdminEnhancedMediaGallerySelectImageForMassActionActionGroup");
		$I->comment("Entering Action Group [clikDeleteSelectedButton] AdminEnhancedMediaGalleryClickDeleteImagesButtonActionGroup");
		$I->click("#delete_selected_massaction"); // stepKey: clickDeleteImagesClikDeleteSelectedButton
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeleteModalClikDeleteSelectedButton
		$I->comment("Exiting Action Group [clikDeleteSelectedButton] AdminEnhancedMediaGalleryClickDeleteImagesButtonActionGroup");
		$I->comment("Entering Action Group [deleteImages] AdminEnhancedMediaGalleryConfirmDeleteImagesActionGroup");
		$I->click(".media-gallery-delete-image-action .action-accept"); // stepKey: confirmDeleteDeleteImages
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForDeletingProccesDeleteImages
		$I->comment("Exiting Action Group [deleteImages] AdminEnhancedMediaGalleryConfirmDeleteImagesActionGroup");
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
	 * @Stories({"[Story 59] User finds image duplicates"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEnhancedMediaGalleryDuplicatedImagesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadImage
		$I->attachFile("#image-uploader-input", "magento.jpg"); // stepKey: uploadImageUploadImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadImage
		$I->comment("Exiting Action Group [uploadImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [uploadSecondImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageFullyLoadedUploadSecondImage
		$I->attachFile("#image-uploader-input", "magento-again.jpg"); // stepKey: uploadImageUploadSecondImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadUploadSecondImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearUploadSecondImage
		$I->comment("Exiting Action Group [uploadSecondImage] AdminEnhancedMediaGalleryUploadImageActionGroup");
		$I->comment("Entering Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-expand']"); // stepKey: expandFilterExpandFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearExpandFilters
		$I->comment("Exiting Action Group [expandFilters] AdminEnhancedMediaGalleryExpandFilterActionGroup");
		$I->comment("Entering Action Group [SelectDuplicatedFilter] AdminEnhancedMediaGalleryApplyDuplicatedFilterActionGroup");
		$I->click("//input[@name='duplicated']"); // stepKey: clickShowDuplicatesSelectDuplicatedFilter
		$I->comment("Exiting Action Group [SelectDuplicatedFilter] AdminEnhancedMediaGalleryApplyDuplicatedFilterActionGroup");
		$I->comment("Entering Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->click("//div[@class='media-gallery-container']//button[@data-action='grid-filter-apply']"); // stepKey: applyFiltersApplyFilters
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearApplyFilters
		$I->comment("Exiting Action Group [applyFilters] AdminEnhancedMediaGalleryApplyFiltersActionGroup");
		$I->comment("Entering Action Group [assertFirstImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
		$I->waitForElementVisible("//li[@data-ui-id='title'and text()='magento']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']", 30); // stepKey: waitForImageToBeVisibleAssertFirstImageInGrid
		$I->comment("Exiting Action Group [assertFirstImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
		$I->comment("Entering Action Group [assertSecondImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
		$I->waitForElementVisible("//li[@data-ui-id='title'and text()='magento-again']/parent::*/parent::*/parent::div//img[@class='media-gallery-image-column']", 30); // stepKey: waitForImageToBeVisibleAssertSecondImageInGrid
		$I->comment("Exiting Action Group [assertSecondImageInGrid] AdminMediaGalleryAssertImageInGridActionGroup");
		$I->comment("Entering Action Group [clearGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearGridFilter] ClearFiltersAdminDataGridActionGroup");
	}
}
