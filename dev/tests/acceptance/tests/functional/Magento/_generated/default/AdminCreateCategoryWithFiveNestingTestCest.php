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
 * @Title("MC-5271: Create category with five nesting")
 * @Description("Login as admin and create nested sub category and verify the subcategory displayed in store front page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateCategoryWithFiveNestingTest.xml<br>")
 * @TestCaseId("MC-5271")
 * @group Catalog
 * @group mtf_migrated
 */
class AdminCreateCategoryWithFiveNestingTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageGoToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadGoToCategoryPage
		$I->comment("Exiting Action Group [goToCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->click("//a/span[contains(text(), 'FirstLevelSubCategory" . msq("FirstLevelSubCat") . "')]"); // stepKey: clickCategoryLink
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDelete
		$I->waitForPageLoad(30); // stepKey: clickDeleteWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModal
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessage
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDelete
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinish
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccess
		$I->comment("Entering Action Group [expandToSeeAllCategories] AdminExpandCategoryTreeActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: clickOnExpandTreeExpandToSeeAllCategories
		$I->waitForPageLoad(30); // stepKey: waitForCategoryToLoadExpandToSeeAllCategories
		$I->comment("Exiting Action Group [expandToSeeAllCategories] AdminExpandCategoryTreeActionGroup");
		$I->dontSee("//a/span[contains(text(), 'FirstLevelSubCategory" . msq("FirstLevelSubCat") . "')]"); // stepKey: dontSeeCategoryInTree
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeWaitForPageLoad
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
	 * @Stories({"Create categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCategoryWithFiveNestingTest(AcceptanceTester $I)
	{
		$I->comment("Create Category with Five Nesting");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Create Nested First Category");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButton
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButtonWaitForPageLoad
		$I->checkOption("input[name='is_active']"); // stepKey: enableCategory
		$I->fillField("input[name='name']", "FirstLevelSubCategory" . msq("FirstLevelSubCat")); // stepKey: fillFirstSubCategoryName
		$I->comment("Entering Action Group [saveFirstSubCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveFirstSubCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveFirstSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveFirstSubCategory
		$I->comment("Exiting Action Group [saveFirstSubCategory] AdminSaveCategoryActionGroup");
		$I->comment("Verify success message");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertSuccessMessage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->comment("Create Nested Second Sub Category");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButton1
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButton1WaitForPageLoad
		$I->fillField("input[name='name']", "SecondLevelSubCategory" . msq("SecondLevelSubCat")); // stepKey: fillSecondSubCategoryName
		$I->comment("Entering Action Group [saveSecondSubCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveSecondSubCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveSecondSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveSecondSubCategory
		$I->comment("Exiting Action Group [saveSecondSubCategory] AdminSaveCategoryActionGroup");
		$I->comment("Verify success message");
		$I->comment("Entering Action Group [assertSuccessMessage1] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertSuccessMessage1
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertSuccessMessage1
		$I->comment("Exiting Action Group [assertSuccessMessage1] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->comment("Create Nested Third Sub Category/>");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButton2
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButton2WaitForPageLoad
		$I->fillField("input[name='name']", "ThirdLevelSubCategory" . msq("ThirdLevelSubCat")); // stepKey: fillThirdSubCategoryName
		$I->comment("Entering Action Group [saveThirdSubCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveThirdSubCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveThirdSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveThirdSubCategory
		$I->comment("Exiting Action Group [saveThirdSubCategory] AdminSaveCategoryActionGroup");
		$I->comment("Verify success message");
		$I->comment("Entering Action Group [assertSuccessMessage2] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertSuccessMessage2
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertSuccessMessage2
		$I->comment("Exiting Action Group [assertSuccessMessage2] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->comment("Create Nested fourth Sub Category />");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButton3
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButton3WaitForPageLoad
		$I->fillField("input[name='name']", "FourthLevelSubCategory" . msq("FourthLevelSubCat")); // stepKey: fillFourthSubCategoryName
		$I->comment("Entering Action Group [saveFourthSubCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveFourthSubCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveFourthSubCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveFourthSubCategory
		$I->comment("Exiting Action Group [saveFourthSubCategory] AdminSaveCategoryActionGroup");
		$I->comment("Verify success message");
		$I->comment("Entering Action Group [assertSuccessMessage3] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertSuccessMessage3
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertSuccessMessage3
		$I->comment("Exiting Action Group [assertSuccessMessage3] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->comment("Create Nested fifth Sub Category />");
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryButton4
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryButton4WaitForPageLoad
		$I->fillField("input[name='name']", "FifthLevelCategory" . msq("FifthLevelCat")); // stepKey: fillFifthSubCategoryName
		$I->comment("Entering Action Group [saveFifthLevelCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveFifthLevelCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveFifthLevelCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveFifthLevelCategory
		$I->comment("Exiting Action Group [saveFifthLevelCategory] AdminSaveCategoryActionGroup");
		$I->comment("Verify success message");
		$I->comment("Entering Action Group [assertSuccessMessage4] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertSuccessMessage4
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertSuccessMessage4
		$I->comment("Exiting Action Group [assertSuccessMessage4] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->amOnPage("/firstlevelsubcategory" . msq("FirstLevelSubCat") . "/secondlevelsubcategory" . msq("SecondLevelSubCat") . "/thirdlevelsubcategory" . msq("ThirdLevelSubCat") . "/fourthlevelsubcategory" . msq("FourthLevelSubCat") . "/fifthlevelcategory" . msq("FifthLevelCat") . ".html"); // stepKey: seeTheCategoryInStoreFrontPage
		$I->waitForPageLoad(60); // stepKey: waitForStoreFrontPageLoad
		$I->comment("<Verify category displayed in store front page");
		$breadcrumbs = $I->grabMultiple(".breadcrumbs li"); // stepKey: breadcrumbs
		$I->assertEquals(['Home', "FirstLevelSubCategory" . msq("FirstLevelSubCat"), "SecondLevelSubCategory" . msq("SecondLevelSubCat"), "ThirdLevelSubCategory" . msq("ThirdLevelSubCat"), "FourthLevelSubCategory" . msq("FourthLevelSubCat"), "FifthLevelCategory" . msq("FifthLevelCat")], $breadcrumbs); // stepKey: verifyTheCategoryInStoreFrontPage
	}
}
