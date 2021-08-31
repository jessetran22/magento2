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
 * @Title("MC-5263: Create Root Category from Category Page")
 * @Description("Create Root Category from Category Page<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateRootCategoryRequiredFieldsTest.xml<br>")
 * @TestCaseId("MC-5263")
 * @group catalog
 * @group mtf_migrated
 */
class AdminCreateRootCategoryRequiredFieldsTestCest
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
		$I->comment("Entering Action Group [LoginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [LoginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteCategory] DeleteCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteCategory
		$I->click("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: clickCategoryLinkDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkDeleteCategoryWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteCategory
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteCategory
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteCategory
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteCategory
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteCategory
		$I->click(".tree-actions a:last-child"); // stepKey: expandToSeeAllCategoriesDeleteCategory
		$I->dontSee("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: dontSeeCategoryInTreeDeleteCategory
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeDeleteCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCategory] DeleteCategoryActionGroup");
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
	 * @Features({"Catalog"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateRootCategoryRequiredFieldsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [OpenAdminCatergoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCatergoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCatergoryIndexPage
		$I->comment("Exiting Action Group [OpenAdminCatergoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->click("#add_root_category_button"); // stepKey: ClickOnAddRootButton
		$I->waitForPageLoad(30); // stepKey: ClickOnAddRootButtonWaitForPageLoad
		$I->fillField("input[name='name']", "simpleCategory" . msq("_defaultCategory")); // stepKey: FillCategoryField
		$I->checkOption("input[name='is_active']"); // stepKey: EnableCheckOption
		$I->comment("Entering Action Group [ClickSaveButton] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedClickSaveButton
		$I->comment("Exiting Action Group [ClickSaveButton] AdminSaveCategoryActionGroup");
		$I->comment("Entering Action Group [AssertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForElementAssertSuccessMessage
		$I->see("You saved the category.", "#messages div.message-success"); // stepKey: seeSuccessMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [AssertSuccessMessage] AssertAdminCategorySaveSuccessMessageActionGroup");
		$I->seeCheckboxIsChecked("input[name='is_active']"); // stepKey: SeeCheckBoxisSelected
		$I->seeInField("input[name='name']", "simpleCategory" . msq("_defaultCategory")); // stepKey: SeedFieldInput
	}
}
