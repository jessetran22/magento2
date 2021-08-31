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
 * @Title("MC-5268: Create disabled subcategory")
 * @Description("Login as admin and create category with inactivated enable category option<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateCategoryWithInactiveCategoryTest.xml<br>")
 * @TestCaseId("MC-5268")
 * @group Catalog
 * @group mtf_migrated
 */
class AdminCreateCategoryWithInactiveCategoryTestCest
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
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCategoryWithInactiveCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Create In active Category");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [createInactiveCategory] AdminCreateInactiveCategoryActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageCreateInactiveCategory
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryCreateInactiveCategory
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryCreateInactiveCategoryWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleCreateInactiveCategory
		$I->click("input[name='is_active']+label"); // stepKey: disableCategoryCreateInactiveCategory
		$I->fillField("input[name='name']", "simpleCategory" . msq("_defaultCategory")); // stepKey: enterCategoryNameCreateInactiveCategory
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOCreateInactiveCategory
		$I->waitForPageLoad(30); // stepKey: openSEOCreateInactiveCategoryWaitForPageLoad
		$I->fillField("input[name='url_key']", "simplecategory" . msq("_defaultCategory")); // stepKey: enterURLKeyCreateInactiveCategory
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryCreateInactiveCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryCreateInactiveCategoryWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessCreateInactiveCategory
		$I->seeInTitle("simpleCategory" . msq("_defaultCategory")); // stepKey: seeNewCategoryPageTitleCreateInactiveCategory
		$I->seeElement("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: seeCategoryInTreeCreateInactiveCategory
		$I->waitForPageLoad(30); // stepKey: seeCategoryInTreeCreateInactiveCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [createInactiveCategory] AdminCreateInactiveCategoryActionGroup");
		$I->comment("Entering Action Group [seeDisabledCategory] AssertAdminCategoryIsInactiveActionGroup");
		$I->dontSeeCheckboxIsChecked("input[name='is_active']"); // stepKey: seeCategoryIsDisabledSeeDisabledCategory
		$I->comment("Exiting Action Group [seeDisabledCategory] AssertAdminCategoryIsInactiveActionGroup");
		$I->comment("Verify Category is not listed store front page");
		$I->comment("Entering Action Group [goToStoreFront] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStoreFront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStoreFront
		$I->comment("Exiting Action Group [goToStoreFront] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [doNotSeeCategoryNameInMenu] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->dontSeeElement("//nav//a[span[contains(., 'simpleCategory" . msq("_defaultCategory") . "')]]"); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeCategoryNameInMenu
		$I->waitForPageLoad(30); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeCategoryNameInMenuWaitForPageLoad
		$I->comment("Exiting Action Group [doNotSeeCategoryNameInMenu] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
	}
}
