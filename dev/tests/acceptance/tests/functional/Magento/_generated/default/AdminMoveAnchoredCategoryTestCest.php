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
 * @Title("MC-10022: Admin should be able to move a category via categories tree and changes should be applied on frontend without a forced cache cleaning")
 * @Description("Admin should be able to move a category via categories tree and changes should be applied on frontend without a forced cache cleaning<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminMoveAnchoredCategoryTest.xml<br>")
 * @TestCaseId("MC-10022")
 * @group category
 */
class AdminMoveAnchoredCategoryTestCest
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
		$I->createEntity("simpleSubCategoryOne", "hook", "SimpleSubCategory", [], []); // stepKey: simpleSubCategoryOne
		$I->createEntity("simpleSubCategoryTwo", "hook", "SimpleSubCategory", [], []); // stepKey: simpleSubCategoryTwo
		$I->createEntity("simpleSubCategoryWithParent", "hook", "SubCategoryWithParent", ["simpleSubCategoryOne"], []); // stepKey: simpleSubCategoryWithParent
		$I->createEntity("productOne", "hook", "_defaultProduct", ["simpleSubCategoryWithParent"], []); // stepKey: productOne
		$I->createEntity("productTwo", "hook", "_defaultProduct", ["simpleSubCategoryOne"], []); // stepKey: productTwo
		$RunToScheduleJobs = $I->magentoCron("index", 90); // stepKey: RunToScheduleJobs
		$I->comment($RunToScheduleJobs);
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
		$I->deleteEntity("productOne", "hook"); // stepKey: deleteProductOne
		$I->deleteEntity("productTwo", "hook"); // stepKey: deleteProductTwo
		$I->deleteEntity("simpleSubCategoryWithParent", "hook"); // stepKey: deleteSubcategoryWithParent
		$I->deleteEntity("simpleSubCategoryOne", "hook"); // stepKey: deleteSubcategoryOne
		$I->deleteEntity("simpleSubCategoryTwo", "hook"); // stepKey: deleteSubcategoryTwo
		$I->comment("Entering Action Group [logoutAdminUserAfterTest] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAdminUserAfterTest
		$I->comment("Exiting Action Group [logoutAdminUserAfterTest] AdminLogoutActionGroup");
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
	 * @Stories({"Edit categories"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMoveAnchoredCategoryTest(AcceptanceTester $I)
	{
		$I->comment("Move category one to category two");
		$I->comment("Entering Action Group [navigateToAdminCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageNavigateToAdminCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadNavigateToAdminCategoryPage
		$I->comment("Exiting Action Group [navigateToAdminCategoryPage] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [moveSimpleSubCategoryOneToSimpleSubCategoryTwo] MoveCategoryActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllCategoriesTreeMoveSimpleSubCategoryOneToSimpleSubCategoryTwo
		$I->waitForAjaxLoad(30); // stepKey: waitForCategoriesExpandMoveSimpleSubCategoryOneToSimpleSubCategoryTwo
		$I->dragAndDrop("//a/span[contains(text(), '" . $I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test') . "')]", "//a/span[contains(text(), '" . $I->retrieveEntityField('simpleSubCategoryTwo', 'name', 'test') . "')]"); // stepKey: moveCategoryMoveSimpleSubCategoryOneToSimpleSubCategoryTwo
		$I->waitForPageLoad(30); // stepKey: moveCategoryMoveSimpleSubCategoryOneToSimpleSubCategoryTwoWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForWarningMessageVisibleMoveSimpleSubCategoryOneToSimpleSubCategoryTwo
		$I->see("This operation can take a long time", "aside.confirm div.modal-content"); // stepKey: seeWarningMessageMoveSimpleSubCategoryOneToSimpleSubCategoryTwo
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: clickOkButtonOnWarningPopupMoveSimpleSubCategoryOneToSimpleSubCategoryTwo
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageReloadMoveSimpleSubCategoryOneToSimpleSubCategoryTwo
		$I->comment("Exiting Action Group [moveSimpleSubCategoryOneToSimpleSubCategoryTwo] MoveCategoryActionGroup");
		$I->comment("Verify that navigation menu categories level is correct");
		$I->comment("Entering Action Group [goToHomePage1] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage1
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage1
		$I->comment("Exiting Action Group [goToHomePage1] StorefrontOpenHomePageActionGroup");
		$I->seeElement("//a[contains(@class,'level-top')]/span[contains(text(),'" . $I->retrieveEntityField('simpleSubCategoryTwo', 'name', 'test') . "')]"); // stepKey: verifyThatTopCategoryIsSubCategoryTwo
		$I->moveMouseOver("//a[contains(@class,'level-top')]/span[contains(text(),'" . $I->retrieveEntityField('simpleSubCategoryTwo', 'name', 'test') . "')]"); // stepKey: mouseOverSubCategoryTwo
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxOnMouseOverSubCategoryTwo
		$I->seeElement("//ul[contains(@class,'submenu')]//span[contains(text(),'" . $I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test') . "')]"); // stepKey: verifyThatFirstLevelIsSubCategoryOne
		$I->moveMouseOver("//ul[contains(@class,'submenu')]//span[contains(text(),'" . $I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test') . "')]"); // stepKey: mouseOverSubCategoryOne
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxOnMouseOverSubCategoryOne
		$I->seeElement("//ul[contains(@class,'submenu')]//span[contains(text(),'" . $I->retrieveEntityField('simpleSubCategoryWithParent', 'name', 'test') . "')]"); // stepKey: verifyThatSecondLevelIsSubCategoryWithParent1
		$I->comment("Open category one via navigation menu. Verify that subcategory is shown in layered navigation");
		$I->click("//ul[contains(@class,'submenu')]//span[contains(text(),'" . $I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test') . "')]"); // stepKey: openSimpleSubCategoryOneByNavigationMenu1
		$I->comment("Entering Action Group [verifySimpleSubCategoryWithParentInLayeredNavigation1] CheckItemInLayeredNavigationActionGroup");
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), 'Category')]", ".filter-options-content .items", false); // stepKey: expandFilterOptionsVerifySimpleSubCategoryWithParentInLayeredNavigation1
		$I->comment("Exiting Action Group [verifySimpleSubCategoryWithParentInLayeredNavigation1] CheckItemInLayeredNavigationActionGroup");
		$I->comment("Open category one by direct URL. Verify simple product is visible on it. Open this product and perform assertions");
		$I->comment("Entering Action Group [openFirstProductFromSubCategoryOneCategoryPage1] OpenProductFromCategoryPageActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleSubCategoryOne', 'custom_attributes[url_path]', 'test') . ".html"); // stepKey: navigateToCategoryPageOpenFirstProductFromSubCategoryOneCategoryPage1
		$I->comment("Go to storefront product page");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('productOne', 'name', 'test') . "')]"); // stepKey: openProductPageOpenFirstProductFromSubCategoryOneCategoryPage1
		$I->waitForAjaxLoad(30); // stepKey: waitForImageLoaderOpenFirstProductFromSubCategoryOneCategoryPage1
		$I->comment("Exiting Action Group [openFirstProductFromSubCategoryOneCategoryPage1] OpenProductFromCategoryPageActionGroup");
		$I->see("Home", ".items"); // stepKey: seeHomePageInBreadcrumbs1
		$I->see($I->retrieveEntityField('simpleSubCategoryTwo', 'name', 'test'), ".items"); // stepKey: seeSubCategoryTwoInBreadcrumbsOnSubCategoryOne
		$I->see($I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test'), ".items"); // stepKey: seeSubCategoryOneInBreadcrumbsOnSubCategoryOne1
		$I->see($I->retrieveEntityField('productOne', 'name', 'test'), ".items"); // stepKey: seeProductInBreadcrumbsOnSubCategoryOne1
		$I->comment("Open category two by direct URL. Verify simple product is visible on it. Open this product and perform assertions");
		$I->comment("Entering Action Group [openFirstProductFromSubCategoryWithParentCategoryPage] OpenProductFromCategoryPageActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleSubCategoryWithParent', 'custom_attributes[url_path]', 'test') . ".html"); // stepKey: navigateToCategoryPageOpenFirstProductFromSubCategoryWithParentCategoryPage
		$I->comment("Go to storefront product page");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('productOne', 'name', 'test') . "')]"); // stepKey: openProductPageOpenFirstProductFromSubCategoryWithParentCategoryPage
		$I->waitForAjaxLoad(30); // stepKey: waitForImageLoaderOpenFirstProductFromSubCategoryWithParentCategoryPage
		$I->comment("Exiting Action Group [openFirstProductFromSubCategoryWithParentCategoryPage] OpenProductFromCategoryPageActionGroup");
		$I->see("Home", ".items"); // stepKey: seeHomePageInBreadcrumbsOnSubCategoryWithParent
		$I->see($I->retrieveEntityField('simpleSubCategoryTwo', 'name', 'test'), ".items"); // stepKey: seeSubCategoryTwoInBreadcrumbsOnSubCategoryWithParent
		$I->see($I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test'), ".items"); // stepKey: seeSubCategoryOneInBreadcrumbsOnSubCategoryWithParent
		$I->see($I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test'), ".items"); // stepKey: seeSubCategoryWithParentInBreadcrumbsOnSubCategoryWithParent
		$I->see($I->retrieveEntityField('productOne', 'name', 'test'), ".items"); // stepKey: seeProductInBreadcrumbsOnSubCategoryWithParent
		$I->comment("Move category one to the same level as category two");
		$I->comment("Entering Action Group [navigateToAdminCategoryPage2] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageNavigateToAdminCategoryPage2
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadNavigateToAdminCategoryPage2
		$I->comment("Exiting Action Group [navigateToAdminCategoryPage2] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [moveSimpleSubCategoryOneToDefaultCategory] MoveCategoryActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllCategoriesTreeMoveSimpleSubCategoryOneToDefaultCategory
		$I->waitForAjaxLoad(30); // stepKey: waitForCategoriesExpandMoveSimpleSubCategoryOneToDefaultCategory
		$I->dragAndDrop("//a/span[contains(text(), '" . $I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test') . "')]", "//a/span[contains(text(), 'Default Category')]"); // stepKey: moveCategoryMoveSimpleSubCategoryOneToDefaultCategory
		$I->waitForPageLoad(30); // stepKey: moveCategoryMoveSimpleSubCategoryOneToDefaultCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForWarningMessageVisibleMoveSimpleSubCategoryOneToDefaultCategory
		$I->see("This operation can take a long time", "aside.confirm div.modal-content"); // stepKey: seeWarningMessageMoveSimpleSubCategoryOneToDefaultCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: clickOkButtonOnWarningPopupMoveSimpleSubCategoryOneToDefaultCategory
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageReloadMoveSimpleSubCategoryOneToDefaultCategory
		$I->comment("Exiting Action Group [moveSimpleSubCategoryOneToDefaultCategory] MoveCategoryActionGroup");
		$I->comment("Verify that navigation menu categories level is correct");
		$I->comment("Entering Action Group [goToHomePage2] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage2
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage2
		$I->comment("Exiting Action Group [goToHomePage2] StorefrontOpenHomePageActionGroup");
		$I->seeElement("//a[contains(@class,'level-top')]/span[contains(text(),'" . $I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test') . "')]"); // stepKey: verifyThatSubCategoryOneIsTopCategory
		$I->seeElement("//a[contains(@class,'level-top')]/span[contains(text(),'" . $I->retrieveEntityField('simpleSubCategoryTwo', 'name', 'test') . "')]"); // stepKey: verifyThatSubCategoryTwoIsTopCategory
		$I->moveMouseOver("//a[contains(@class,'level-top')]/span[contains(text(),'" . $I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test') . "')]"); // stepKey: mouseOverTopSubCategoryOne
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxOnMouseOverTopSubCategoryOne
		$I->seeElement("//ul[contains(@class,'submenu')]//span[contains(text(),'" . $I->retrieveEntityField('simpleSubCategoryWithParent', 'name', 'test') . "')]"); // stepKey: verifyThatSecondLevelIsSubCategoryWithParent2
		$I->comment("Open category one via navigation menu. Verify that subcategory is shown in layered navigation");
		$I->click("//a[contains(@class,'level-top')]/span[contains(text(),'" . $I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test') . "')]"); // stepKey: openSimpleSubCategoryOneByNavigationMenu2
		$I->comment("Entering Action Group [verifySimpleSubCategoryWithParentInLayeredNavigation2] CheckItemInLayeredNavigationActionGroup");
		$I->conditionalClick("//div[@class='filter-options-title' and contains(text(), 'Category')]", ".filter-options-content .items", false); // stepKey: expandFilterOptionsVerifySimpleSubCategoryWithParentInLayeredNavigation2
		$I->comment("Exiting Action Group [verifySimpleSubCategoryWithParentInLayeredNavigation2] CheckItemInLayeredNavigationActionGroup");
		$I->comment("Open category one by direct URL. Verify simple product is visible on it. Open this product and perform assertions");
		$I->comment("Entering Action Group [openFirstProductFromSubCategoryOneCategoryPage2] OpenProductFromCategoryPageActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleSubCategoryOne', 'custom_attributes[url_path]', 'test') . ".html"); // stepKey: navigateToCategoryPageOpenFirstProductFromSubCategoryOneCategoryPage2
		$I->comment("Go to storefront product page");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('productOne', 'name', 'test') . "')]"); // stepKey: openProductPageOpenFirstProductFromSubCategoryOneCategoryPage2
		$I->waitForAjaxLoad(30); // stepKey: waitForImageLoaderOpenFirstProductFromSubCategoryOneCategoryPage2
		$I->comment("Exiting Action Group [openFirstProductFromSubCategoryOneCategoryPage2] OpenProductFromCategoryPageActionGroup");
		$I->see("Home", ".items"); // stepKey: seeHomePageInBreadcrumbs2
		$I->see($I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test'), ".items"); // stepKey: seeSubCategoryOneInBreadcrumbsOnSubCategoryOne2
		$I->see($I->retrieveEntityField('productOne', 'name', 'test'), ".items"); // stepKey: seeProductInBreadcrumbsOnSubCategoryOne2
		$I->comment("Open category subcategory by direct URL. Verify simple product is visible on it. Open this product and perform assertions");
		$I->comment("Entering Action Group [openFirstProductFromSubCategoryOneCategoryPage3] OpenProductFromCategoryPageActionGroup");
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleSubCategoryWithParent', 'custom_attributes[url_path]', 'test') . ".html"); // stepKey: navigateToCategoryPageOpenFirstProductFromSubCategoryOneCategoryPage3
		$I->comment("Go to storefront product page");
		$I->click("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('productOne', 'name', 'test') . "')]"); // stepKey: openProductPageOpenFirstProductFromSubCategoryOneCategoryPage3
		$I->waitForAjaxLoad(30); // stepKey: waitForImageLoaderOpenFirstProductFromSubCategoryOneCategoryPage3
		$I->comment("Exiting Action Group [openFirstProductFromSubCategoryOneCategoryPage3] OpenProductFromCategoryPageActionGroup");
		$I->see("Home", ".items"); // stepKey: seeHomePageInBreadcrumbs3
		$I->see($I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test'), ".items"); // stepKey: seeSubCategoryOneInBreadcrumbsOnSubCategoryOne3
		$I->see($I->retrieveEntityField('simpleSubCategoryOne', 'name', 'test'), ".items"); // stepKey: seeSubCategoryWithParentInBreadcrumbsOnSubCategoryWithParent3
		$I->see($I->retrieveEntityField('productOne', 'name', 'test'), ".items"); // stepKey: seeProductInBreadcrumbsOnSubCategoryOne3
	}
}
