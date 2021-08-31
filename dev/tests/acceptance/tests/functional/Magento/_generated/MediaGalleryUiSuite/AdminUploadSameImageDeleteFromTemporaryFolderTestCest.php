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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/943908/scenarios/4836631: Image is deleted from tmp folder if is uploaded second time")
 * @Description("Image is deleted from tmp folder if is uploaded second time<h3>Test files</h3>app/code/Magento/MediaGalleryCatalogIntegration/Test/Mftf/Test/AdminUploadSameImageDeleteFromTemporaryFolderTest.xml<br>")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/943908/scenarios/4836631")
 * @group media_gallery_ui
 */
class AdminUploadSameImageDeleteFromTemporaryFolderTestCest
{
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
	 * @Features({"MediaGalleryCatalogIntegration"})
	 * @Stories({"Image is deleted from tmp folder if is uploaded second time"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUploadSameImageDeleteFromTemporaryFolderTest(AcceptanceTester $I)
	{
		$I->comment("Upload test image to category twice");
		$I->comment("Entering Action Group [openCategoryPage] AdminOpenCategoryGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/media_gallery_catalog/category/index"); // stepKey: navigateToCategoryGridPageOpenCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenCategoryPage
		$I->comment("Exiting Action Group [openCategoryPage] AdminOpenCategoryGridPageActionGroup");
		$I->comment("Entering Action Group [editCategoryItem] AdminEditCategoryInGridPageActionGroup");
		$I->click("//tr[td//text()[contains(., '" . $I->retrieveEntityField('category', 'name', 'test') . "')]]//td[count(//div[@data-role='grid-wrapper']//tr//th[contains(., 'Action')]/preceding-sibling::th) +1 ]//*[text()='Edit']"); // stepKey: clickOnCategoryRowEditCategoryItem
		$I->waitForPageLoad(30); // stepKey: waitForCategoryDetailsPageLoadEditCategoryItem
		$I->comment("Exiting Action Group [editCategoryItem] AdminEditCategoryInGridPageActionGroup");
		$I->comment("Entering Action Group [addCategoryImage] AddCategoryImageActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: openContentSectionAddCategoryImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddCategoryImage
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Upload']", 30); // stepKey: seeImageSectionIsReadyAddCategoryImage
		$I->attachFile(".file-uploader-area>input", "magento-logo.png"); // stepKey: uploadFileAddCategoryImage
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxUploadAddCategoryImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingAddCategoryImage
		$grabCategoryFileNameAddCategoryImage = $I->grabTextFrom(".file-uploader-filename"); // stepKey: grabCategoryFileNameAddCategoryImage
		$I->assertRegExp("/magento-logo(_[0-9]+)*?\.png$/", $grabCategoryFileNameAddCategoryImage, "pass"); // stepKey: assertEqualsAddCategoryImage
		$I->comment("Exiting Action Group [addCategoryImage] AddCategoryImageActionGroup");
		$I->comment("Entering Action Group [saveCategoryForm] AdminSaveCategoryFormActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageSaveCategoryForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfTheCategoryPageSaveCategoryForm
		$I->click("#save"); // stepKey: saveCategorySaveCategoryForm
		$I->waitForPageLoad(30); // stepKey: saveCategorySaveCategoryFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveCategoryForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCategoryForm
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: assertSuccessMessageSaveCategoryForm
		$I->comment("Exiting Action Group [saveCategoryForm] AdminSaveCategoryFormActionGroup");
		$I->comment("Entering Action Group [addCategoryImageSecondTime] AddCategoryImageActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: openContentSectionAddCategoryImageSecondTime
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddCategoryImageSecondTime
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Upload']", 30); // stepKey: seeImageSectionIsReadyAddCategoryImageSecondTime
		$I->attachFile(".file-uploader-area>input", "magento-logo.png"); // stepKey: uploadFileAddCategoryImageSecondTime
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxUploadAddCategoryImageSecondTime
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingAddCategoryImageSecondTime
		$grabCategoryFileNameAddCategoryImageSecondTime = $I->grabTextFrom(".file-uploader-filename"); // stepKey: grabCategoryFileNameAddCategoryImageSecondTime
		$I->assertRegExp("/magento-logo(_[0-9]+)*?\.png$/", $grabCategoryFileNameAddCategoryImageSecondTime, "pass"); // stepKey: assertEqualsAddCategoryImageSecondTime
		$I->comment("Exiting Action Group [addCategoryImageSecondTime] AddCategoryImageActionGroup");
		$I->comment("Entering Action Group [saveCategoryFormSecondTime] AdminSaveCategoryFormActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageSaveCategoryFormSecondTime
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfTheCategoryPageSaveCategoryFormSecondTime
		$I->click("#save"); // stepKey: saveCategorySaveCategoryFormSecondTime
		$I->waitForPageLoad(30); // stepKey: saveCategorySaveCategoryFormSecondTimeWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveCategoryFormSecondTime
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCategoryFormSecondTime
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: assertSuccessMessageSaveCategoryFormSecondTime
		$I->comment("Exiting Action Group [saveCategoryFormSecondTime] AdminSaveCategoryFormActionGroup");
		$I->comment("Open tmp/category folder");
		$I->comment("Entering Action Group [openMediaGallery] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Select from Gallery']", false); // stepKey: clickExpandContentOpenMediaGallery
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Select from Gallery']", 30); // stepKey: waitForSelectFromGalleryOpenMediaGallery
		$I->click("//*[@class='file-uploader-area']/label[text()='Select from Gallery']"); // stepKey: clickSelectFromGalleryOpenMediaGallery
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadOpenMediaGallery
		$I->comment("Exiting Action Group [openMediaGallery] AdminOpenMediaGalleryFromCategoryImageUploaderActionGroup");
		$I->comment("Entering Action Group [expandTmpFolder] AdminEnhancedMediaGalleryExpandCatalogTmpFolderActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitLoadingMaskExpandTmpFolder
		$I->conditionalClick("//li[@id='catalog']/ins", "//li[@id='catalog']/ul", false); // stepKey: expandCatalogExpandTmpFolder
		$I->wait(2); // stepKey: waitCatalogExpandedExpandTmpFolder
		$I->conditionalClick("//li[@id='catalog/tmp']/ins", "//li[@id='catalog/tmp']/ul", false); // stepKey: expandTmpExpandTmpFolder
		$I->wait(2); // stepKey: waitTmpExpandedExpandTmpFolder
		$I->comment("Exiting Action Group [expandTmpFolder] AdminEnhancedMediaGalleryExpandCatalogTmpFolderActionGroup");
		$I->comment("Entering Action Group [selectCategoryFolder] AdminMediaGalleryFolderSelectByFullPathActionGroup");
		$I->wait(2); // stepKey: waitBeforeClickOnFolderSelectCategoryFolder
		$I->click("//li[@id='catalog/tmp/category']"); // stepKey: selectSubFolderSelectCategoryFolder
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForFolderContentsSelectCategoryFolder
		$I->comment("Exiting Action Group [selectCategoryFolder] AdminMediaGalleryFolderSelectByFullPathActionGroup");
		$I->comment("Assert folder is empty");
		$I->comment("Entering Action Group [assertEmptyFolder] AdminAssertMediaGalleryEmptyActionGroup");
		$I->seeElement("[data-id='media-gallery-masonry-grid'] .no-data-message-container"); // stepKey: assertNoDataMessageDisplayedAssertEmptyFolder
		$I->comment("Exiting Action Group [assertEmptyFolder] AdminAssertMediaGalleryEmptyActionGroup");
	}
}
