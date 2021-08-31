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
 * @Title("MC-212: Admin should be able to remove image from a Category")
 * @Description("Admin should be able to remove image from a Category<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminRemoveImageFromCategoryTest.xml<br>")
 * @TestCaseId("MC-212")
 * @group Catalog
 */
class AdminRemoveImageFromCategoryTestCest
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
		$I->comment("Entering Action Group [DeleteCategory] DeleteCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteCategory
		$I->click("//a/span[contains(text(), 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]"); // stepKey: clickCategoryLinkDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkDeleteCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandToSeeAllCategoriesDeleteCategory
		$I->dontSee("//a/span[contains(text(), 'SimpleSubCategory" . msq("SimpleSubCategory") . "')]"); // stepKey: dontSeeCategoryInTreeDeleteCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeDeleteCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [DeleteCategory] DeleteCategoryActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminRemoveImageFromCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Go to create a new category with image");
		$I->comment("Entering Action Group [goToCreateCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: amOnAdminCategoryPageGoToCreateCategoryPage
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageGoToCreateCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCreateCategoryPage
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddCategoryGoToCreateCategoryPage
		$I->waitForPageLoad(30); // stepKey: clickOnAddCategoryGoToCreateCategoryPageWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleGoToCreateCategoryPage
		$I->comment("Exiting Action Group [goToCreateCategoryPage] GoToCreateCategoryPageActionGroup");
		$I->comment("Entering Action Group [fillCategoryForm] FillCategoryFormActionGroup");
		$I->fillField("input[name='name']", "SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: enterCategoryNameFillCategoryForm
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOFillCategoryForm
		$I->waitForPageLoad(30); // stepKey: openSEOFillCategoryFormWaitForPageLoad
		$I->fillField("input[name='url_key']", "simplesubcategory" . msq("SimpleSubCategory")); // stepKey: enterURLKeyFillCategoryForm
		$I->comment("Exiting Action Group [fillCategoryForm] FillCategoryFormActionGroup");
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
		$I->comment("Entering Action Group [checkCategoryImageInAdmin] CheckCategoryImageInAdminActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: openContentSectionCheckCategoryImageInAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCheckCategoryImageInAdmin
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Upload']", 30); // stepKey: seeImageSectionIsReadyCheckCategoryImageInAdmin
		$grabCategoryFileNameCheckCategoryImageInAdmin = $I->grabTextFrom(".file-uploader-filename"); // stepKey: grabCategoryFileNameCheckCategoryImageInAdmin
		$I->assertRegExp("/magento-logo(_[0-9]+)*?\.png$/", $grabCategoryFileNameCheckCategoryImageInAdmin, "pass"); // stepKey: assertEqualsCheckCategoryImageInAdmin
		$I->comment("Exiting Action Group [checkCategoryImageInAdmin] CheckCategoryImageInAdminActionGroup");
		$I->comment("Remove image from category");
		$I->comment("Entering Action Group [removeCategoryImage] RemoveCategoryImageActionGroup");
		$I->conditionalClick("div[data-index='content']", "//*[@class='file-uploader-area']/label[text()='Upload']", false); // stepKey: openContentSectionRemoveCategoryImage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadRemoveCategoryImage
		$I->waitForElementVisible("//*[@class='file-uploader-area']/label[text()='Upload']", 30); // stepKey: seeImageSectionIsReadyRemoveCategoryImage
		$I->click(".file-uploader-summary .action-remove"); // stepKey: clickRemoveImageRemoveCategoryImage
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxUploadRemoveCategoryImage
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingRemoveCategoryImage
		$I->dontSee(".file-uploader-filename"); // stepKey: dontSeeImageRemoveCategoryImage
		$I->comment("Exiting Action Group [removeCategoryImage] RemoveCategoryImageActionGroup");
		$I->comment("Entering Action Group [saveCategoryFormAfterRemove] AdminSaveCategoryFormActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageSaveCategoryFormAfterRemove
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfTheCategoryPageSaveCategoryFormAfterRemove
		$I->click("#save"); // stepKey: saveCategorySaveCategoryFormAfterRemove
		$I->waitForPageLoad(30); // stepKey: saveCategorySaveCategoryFormAfterRemoveWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsSaveCategoryFormAfterRemove
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveCategoryFormAfterRemove
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: assertSuccessMessageSaveCategoryFormAfterRemove
		$I->comment("Exiting Action Group [saveCategoryFormAfterRemove] AdminSaveCategoryFormActionGroup");
		$I->comment("Entering Action Group [CheckCategoryOnStorefront] CheckCategoryOnStorefrontActionGroup");
		$I->amOnPage("/simplesubcategory" . msq("SimpleSubCategory") . ".html"); // stepKey: goToCategoryFrontPageCheckCategoryOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CheckCategoryOnStorefront
		$I->see("simplesubcategory" . msq("SimpleSubCategory"), "#page-title-heading span"); // stepKey: assertCategoryOnStorefrontCheckCategoryOnStorefront
		$I->seeInTitle("SimpleSubCategory" . msq("SimpleSubCategory")); // stepKey: seeCategoryNameInTitleCheckCategoryOnStorefront
		$I->comment("Exiting Action Group [CheckCategoryOnStorefront] CheckCategoryOnStorefrontActionGroup");
		$I->comment("Verify category with no image in storefront");
		$I->dontSee(".category-image"); // stepKey: dontSeeImage
	}
}
