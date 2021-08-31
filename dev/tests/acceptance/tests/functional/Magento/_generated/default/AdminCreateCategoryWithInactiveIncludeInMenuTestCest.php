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
 * @Title("MC-5269: Create not included in menu subcategory")
 * @Description("Login as admin and create category with inactivated include in menu option<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminCreateCategoryWithInactiveIncludeInMenuTest.xml<br>")
 * @TestCaseId("MC-5269")
 * @group Catalog
 * @group mtf_migrated
 */
class AdminCreateCategoryWithInactiveIncludeInMenuTestCest
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
	public function AdminCreateCategoryWithInactiveIncludeInMenuTest(AcceptanceTester $I)
	{
		$I->comment("Create Category with not included in menu Subcategory");
		$I->comment("Entering Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageOpenAdminCategoryIndexPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadOpenAdminCategoryIndexPage
		$I->comment("Exiting Action Group [openAdminCategoryIndexPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [createNotIncludedInMenuCategory] AdminCreateCategoryWithInactiveIncludeInMenuActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: seeOnCategoryPageCreateNotIncludedInMenuCategory
		$I->click("#add_subcategory_button"); // stepKey: clickOnAddSubCategoryCreateNotIncludedInMenuCategory
		$I->waitForPageLoad(30); // stepKey: clickOnAddSubCategoryCreateNotIncludedInMenuCategoryWaitForPageLoad
		$I->see("New Category", ".page-header h1.page-title"); // stepKey: seeCategoryPageTitleCreateNotIncludedInMenuCategory
		$I->click("input[name='include_in_menu']+label"); // stepKey: disableIncludeInMenuOptionCreateNotIncludedInMenuCategory
		$I->fillField("input[name='name']", "simpleCategory" . msq("_defaultCategory")); // stepKey: enterCategoryNameCreateNotIncludedInMenuCategory
		$I->click("div[data-index='search_engine_optimization'] .fieldset-wrapper-title"); // stepKey: openSEOCreateNotIncludedInMenuCategory
		$I->waitForPageLoad(30); // stepKey: openSEOCreateNotIncludedInMenuCategoryWaitForPageLoad
		$I->fillField("input[name='url_key']", "simplecategory" . msq("_defaultCategory")); // stepKey: enterURLKeyCreateNotIncludedInMenuCategory
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryCreateNotIncludedInMenuCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryCreateNotIncludedInMenuCategoryWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: assertSuccessCreateNotIncludedInMenuCategory
		$I->seeInTitle("simpleCategory" . msq("_defaultCategory")); // stepKey: seeNewCategoryPageTitleCreateNotIncludedInMenuCategory
		$I->seeElement("//a/span[contains(text(), 'simpleCategory" . msq("_defaultCategory") . "')]"); // stepKey: seeCategoryInTreeCreateNotIncludedInMenuCategory
		$I->waitForPageLoad(30); // stepKey: seeCategoryInTreeCreateNotIncludedInMenuCategoryWaitForPageLoad
		$I->comment("Exiting Action Group [createNotIncludedInMenuCategory] AdminCreateCategoryWithInactiveIncludeInMenuActionGroup");
		$I->comment("Verify Category in store front page menu/>");
		$I->comment("Entering Action Group [CheckCategoryOnStorefront] CheckCategoryOnStorefrontActionGroup");
		$I->amOnPage("/simplecategory" . msq("_defaultCategory") . ".html"); // stepKey: goToCategoryFrontPageCheckCategoryOnStorefront
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CheckCategoryOnStorefront
		$I->see("simplecategory" . msq("_defaultCategory"), "#page-title-heading span"); // stepKey: assertCategoryOnStorefrontCheckCategoryOnStorefront
		$I->seeInTitle("simpleCategory" . msq("_defaultCategory")); // stepKey: seeCategoryNameInTitleCheckCategoryOnStorefront
		$I->comment("Exiting Action Group [CheckCategoryOnStorefront] CheckCategoryOnStorefrontActionGroup");
		$I->comment("Entering Action Group [doNotSeeCategoryOnNavigation] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
		$I->dontSeeElement("//nav//a[span[contains(., 'simpleCategory" . msq("_defaultCategory") . "')]]"); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeCategoryOnNavigation
		$I->waitForPageLoad(30); // stepKey: doNotSeeCatergoryInStoreFrontDoNotSeeCategoryOnNavigationWaitForPageLoad
		$I->comment("Exiting Action Group [doNotSeeCategoryOnNavigation] StorefrontAssertCategoryNameIsNotShownInMenuActionGroup");
	}
}
