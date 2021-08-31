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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4753539: User deletes images with less clicks")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1054245/scenarios/4753539")
 * @Description("User deletes images with less clicks<h3>Test files</h3>app/code/Magento/MediaGalleryUi/Test/Mftf/Test/AdminEnhancedMediaGalleryDeleteImagesInBulkTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminEnhancedMediaGalleryDeleteImagesInBulkTestCest
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
		$I->comment("Entering Action Group [openCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [openCategory] AdminCategoriesOpenCategoryActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('category', 'name', 'hook') . "')]"); // stepKey: clickCategoryLinkOpenCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkOpenCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadOpenCategory
		$I->comment("Exiting Action Group [openCategory] AdminCategoriesOpenCategoryActionGroup");
		$I->comment("Entering Action Group [openMediaGalleryFromWysiwyg] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Select from Gallery']", false); // stepKey: clickExpandContentOpenMediaGalleryFromWysiwyg
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Select from Gallery']", 30); // stepKey: waitForSelectFromGalleryOpenMediaGalleryFromWysiwyg
		$I->click("//*[@class='file-uploader-area']/label[text()='Select from Gallery']"); // stepKey: clickSelectFromGalleryOpenMediaGalleryFromWysiwyg
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGalleryFromWysiwyg
		$I->comment("Exiting Action Group [openMediaGalleryFromWysiwyg] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"[Story #42] User deletes images in bulk"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEnhancedMediaGalleryDeleteImagesInBulkTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [enableMassActionToVerifyMode] AdminEnhancedMediaGalleryEnableMassActionModeActionGroup");
		$I->wait(5); // stepKey: waitBeforeEnableMassActionToVerifyMode
		$I->waitForElementVisible("#delete_massaction", 30); // stepKey: waitForMassActionButtonEnableMassActionToVerifyMode
		$I->click("#delete_massaction"); // stepKey: clickOnMassActionButtonEnableMassActionToVerifyMode
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedEnableMassActionToVerifyMode
		$I->wait(5); // stepKey: waitAfterEnableMassActionToVerifyMode
		$I->comment("Exiting Action Group [enableMassActionToVerifyMode] AdminEnhancedMediaGalleryEnableMassActionModeActionGroup");
		$I->comment("Entering Action Group [assertMassActionModeAvailable] AdminEnhancedMediaGalleryAssertMassActionModeDetailsActionGroup");
		$I->checkOption("//input[@type='checkbox'][@data-ui-id ='magento']"); // stepKey: selectImageInGridToDelteAssertMassActionModeAvailable
		$I->waitForText("(1 Selected)", 30, ".mediagallery-massaction-items-count > .selected_count_text"); // stepKey: verifySelectedCountAssertMassActionModeAvailable
		$I->comment("Exiting Action Group [assertMassActionModeAvailable] AdminEnhancedMediaGalleryAssertMassActionModeDetailsActionGroup");
		$I->comment("Entering Action Group [disableMassActionMode] AdminEnhancedMediaGalleryDisableMassactionModeActionGroup");
		$I->click("#cancel_massaction"); // stepKey: cancelMassActionDisableMassActionMode
		$I->dontSeeElement(".mediagallery-massaction-items-count > .selected_count_text"); // stepKey: verifyTeminateMAssActionDisableMassActionMode
		$I->comment("Exiting Action Group [disableMassActionMode] AdminEnhancedMediaGalleryDisableMassactionModeActionGroup");
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
		$I->comment("Entering Action Group [assertImagesDeleted] AdminEnhancedMediaGalleryAssertImagesDeletedInBulkActionGroup");
		$I->waitForText("2 assets have been successfully deleted.", 30); // stepKey: verifyDeleteImagesAssertImagesDeleted
		$I->comment("Exiting Action Group [assertImagesDeleted] AdminEnhancedMediaGalleryAssertImagesDeletedInBulkActionGroup");
		$I->comment("Entering Action Group [assertMassectionModeDisabled] AdminEnhancedMediaGalleryAssertMassActionModeNotActiveActionGroup");
		$I->dontSeeElement(".media-gallery-add-selected"); // stepKey: verifyAddSelectedButtonNotVisibleAssertMassectionModeDisabled
		$I->dontSeeElement(".mediagallery-massaction-items-count > .selected_count_text"); // stepKey: verifyTeminateMassActionAssertMassectionModeDisabled
		$I->comment("Exiting Action Group [assertMassectionModeDisabled] AdminEnhancedMediaGalleryAssertMassActionModeNotActiveActionGroup");
	}
}
