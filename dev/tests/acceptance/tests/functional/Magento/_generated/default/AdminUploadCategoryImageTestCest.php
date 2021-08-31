<?php
namespace Magento\AcceptanceTest\_default\Backend;

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
 * @Title("MC-26112: Upload Category Image")
 * @Description("The test verifies uploading images including a special case of image name with spaces<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateCategoryTest/AdminUploadCategoryImageTest.xml<br>")
 * @TestCaseId("MC-26112")
 * @group catalog
 */
class AdminUploadCategoryImageTestCest
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
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
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
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"Catalog"})
	 * @Stories({"Add/remove images and videos for all product types and category"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUploadCategoryImageTest(AcceptanceTester $I)
	{
		$I->comment("Go to created category admin page and upload image");
		$I->comment("Entering Action Group [goToAdminCategoryPage] GoToAdminCategoryPageByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/edit/id/" . $I->retrieveEntityField('createCategory', 'id', 'test') . "/"); // stepKey: amOnAdminCategoryPageGoToAdminCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToAdminCategoryPage
		$I->see($I->retrieveEntityField('createCategory', 'id', 'test'), ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleGoToAdminCategoryPage
		$I->comment("Exiting Action Group [goToAdminCategoryPage] GoToAdminCategoryPageByIdActionGroup");
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
		$I->comment("Entering Action Group [checkCategoryImageInAdmin] CheckCategoryImageInAdminActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: openContentSectionCheckCategoryImageInAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCheckCategoryImageInAdmin
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Upload']", 30); // stepKey: seeImageSectionIsReadyCheckCategoryImageInAdmin
		$grabCategoryFileNameCheckCategoryImageInAdmin = $I->grabTextFrom(".file-uploader-filename"); // stepKey: grabCategoryFileNameCheckCategoryImageInAdmin
		$I->assertRegExp("/magento-logo(_[0-9]+)*?\.png$/", $grabCategoryFileNameCheckCategoryImageInAdmin, "pass"); // stepKey: assertEqualsCheckCategoryImageInAdmin
		$I->comment("Exiting Action Group [checkCategoryImageInAdmin] CheckCategoryImageInAdminActionGroup");
		$I->comment("Remove and upload new image");
		$I->comment("Entering Action Group [removeCategoryImage] RemoveCategoryImageActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: openContentSectionRemoveCategoryImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadRemoveCategoryImage
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Upload']", 30); // stepKey: seeImageSectionIsReadyRemoveCategoryImage
		$I->click(".file-uploader-summary .action-remove"); // stepKey: clickRemoveImageRemoveCategoryImage
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxUploadRemoveCategoryImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingRemoveCategoryImage
		$I->dontSee(".file-uploader-filename"); // stepKey: dontSeeImageRemoveCategoryImage
		$I->comment("Exiting Action Group [removeCategoryImage] RemoveCategoryImageActionGroup");
		$I->comment("Entering Action Group [addCategoryImageAgain] AddCategoryImageActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: openContentSectionAddCategoryImageAgain
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddCategoryImageAgain
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Upload']", 30); // stepKey: seeImageSectionIsReadyAddCategoryImageAgain
		$I->attachFile(".file-uploader-area>input", "magento-logo_2.png"); // stepKey: uploadFileAddCategoryImageAgain
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxUploadAddCategoryImageAgain
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingAddCategoryImageAgain
		$grabCategoryFileNameAddCategoryImageAgain = $I->grabTextFrom(".file-uploader-filename"); // stepKey: grabCategoryFileNameAddCategoryImageAgain
		$I->assertRegExp("/magento-logo(_[0-9]+)*?\.png$/", $grabCategoryFileNameAddCategoryImageAgain, "pass"); // stepKey: assertEqualsAddCategoryImageAgain
		$I->comment("Exiting Action Group [addCategoryImageAgain] AddCategoryImageActionGroup");
		$I->comment("Entering Action Group [checkCategoryImageInAdminAgain] CheckCategoryImageInAdminActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: openContentSectionCheckCategoryImageInAdminAgain
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCheckCategoryImageInAdminAgain
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Upload']", 30); // stepKey: seeImageSectionIsReadyCheckCategoryImageInAdminAgain
		$grabCategoryFileNameCheckCategoryImageInAdminAgain = $I->grabTextFrom(".file-uploader-filename"); // stepKey: grabCategoryFileNameCheckCategoryImageInAdminAgain
		$I->assertRegExp("/magento-logo(_[0-9]+)*?\.png$/", $grabCategoryFileNameCheckCategoryImageInAdminAgain, "pass"); // stepKey: assertEqualsCheckCategoryImageInAdminAgain
		$I->comment("Exiting Action Group [checkCategoryImageInAdminAgain] CheckCategoryImageInAdminActionGroup");
	}
}
