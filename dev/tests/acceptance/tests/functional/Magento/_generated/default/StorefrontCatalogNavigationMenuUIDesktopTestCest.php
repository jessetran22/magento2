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
 * @Title("MC-11329: Storefront Catalog Navigation Menu UI, desktop")
 * @Description("Verify UI of Navigation Menu functionality on Storefront<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontCatalogNavigationMenuUIDesktopTest.xml<br>")
 * @TestCaseId("MC-11329")
 * @group catalog
 * @group theme
 */
class StorefrontCatalogNavigationMenuUIDesktopTestCest
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
		$I->comment("Login as admin");
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
		$I->comment("Entering Action Group [changeThemeToDefault] AdminChangeStorefrontThemeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/theme/design_config/"); // stepKey: navigateToDesignConfigPageChangeThemeToDefault
		$I->click("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)= 'Store View']/preceding-sibling::th)+1][contains(.,'Default Store View')]/..//a[contains(@class, 'action-menu-item')]"); // stepKey: editScopeConfigChangeThemeToDefault
		$I->waitForPageLoad(30); // stepKey: editScopeConfigChangeThemeToDefaultWaitForPageLoad
		$I->selectOption("select[name='theme_theme_id']", "Magento Luma"); // stepKey: selectThemeChangeThemeToDefault
		$I->click("#save"); // stepKey: clickSaveChangeThemeToDefault
		$I->waitForPageLoad(30); // stepKey: clickSaveChangeThemeToDefaultWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageChangeThemeToDefault
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageChangeThemeToDefault
		$I->comment("Exiting Action Group [changeThemeToDefault] AdminChangeStorefrontThemeActionGroup");
		$I->comment("Admin log out");
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
	 * @Stories({"Storefront Catalog Navigation Menu UI"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCatalogNavigationMenuUIDesktopTest(AcceptanceTester $I)
	{
		$I->comment("Go to Content > Themes. Change theme to Blank");
		$I->comment("Entering Action Group [changeThemeToBlank] AdminChangeStorefrontThemeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/theme/design_config/"); // stepKey: navigateToDesignConfigPageChangeThemeToBlank
		$I->click("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)= 'Store View']/preceding-sibling::th)+1][contains(.,'Default Store View')]/..//a[contains(@class, 'action-menu-item')]"); // stepKey: editScopeConfigChangeThemeToBlank
		$I->waitForPageLoad(30); // stepKey: editScopeConfigChangeThemeToBlankWaitForPageLoad
		$I->selectOption("select[name='theme_theme_id']", "Magento Blank"); // stepKey: selectThemeChangeThemeToBlank
		$I->click("#save"); // stepKey: clickSaveChangeThemeToBlank
		$I->waitForPageLoad(30); // stepKey: clickSaveChangeThemeToBlankWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageChangeThemeToBlank
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageChangeThemeToBlank
		$I->comment("Exiting Action Group [changeThemeToBlank] AdminChangeStorefrontThemeActionGroup");
		$I->comment("Open storefront");
		$I->comment("Entering Action Group [openStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStorefrontPage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStorefrontPage
		$I->comment("Exiting Action Group [openStorefrontPage] StorefrontOpenHomePageActionGroup");
		$I->comment("Assert single row - no hover state");
		$I->createEntity("createFirstCategoryBlank", "test", "ApiCategoryA", [], []); // stepKey: createFirstCategoryBlank
		$I->comment("Entering Action Group [refreshPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageRefreshPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadRefreshPage
		$I->comment("Exiting Action Group [refreshPage] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createFirstCategoryBlank', 'name', 'test') . "')]]"); // stepKey: hoverFirstCategoryBlank
		$I->waitForPageLoad(30); // stepKey: hoverFirstCategoryBlankWaitForPageLoad
		$I->dontSeeElement(".level0 .submenu a:hover"); // stepKey: assertNoHoverState
		$I->comment("Create categories");
		$I->createEntity("createSecondCategoryBlank", "test", "ApiCategoryTest", [], []); // stepKey: createSecondCategoryBlank
		$I->createEntity("createThirdCategoryBlank", "test", "ApiCategoryTest2", [], []); // stepKey: createThirdCategoryBlank
		$I->createEntity("createFourthCategoryBlank", "test", "ApiCategoryTest3", [], []); // stepKey: createFourthCategoryBlank
		$I->createEntity("createFifthCategoryBlank", "test", "ApiCategorySeveralProducts", [], []); // stepKey: createFifthCategoryBlank
		$I->createEntity("createSixthCategoryBlank", "test", "ApiCategoryTest5", [], []); // stepKey: createSixthCategoryBlank
		$I->createEntity("createSeventhCategoryBlank", "test", "ApiCategoryTest8", [], []); // stepKey: createSeventhCategoryBlank
		$I->createEntity("createEighthCategoryBlank", "test", "ApiCategoryLongTitle", [], []); // stepKey: createEighthCategoryBlank
		$I->createEntity("createNinthCategoryBlank", "test", "ApiCategoryTest6", [], []); // stepKey: createNinthCategoryBlank
		$I->createEntity("createTenthCategoryBlank", "test", "ApiCategoryTest7", [], []); // stepKey: createTenthCategoryBlank
		$I->createEntity("createEleventhCategoryBlank", "test", "ApiCategoryTest4", [], []); // stepKey: createEleventhCategoryBlank
		$I->createEntity("createTwelfthCategoryBlank", "test", "ApiCategoryWithImage", [], []); // stepKey: createTwelfthCategoryBlank
		$I->createEntity("createThirteenthCategoryBlank", "test", "ApiCategoryTest0", [], []); // stepKey: createThirteenthCategoryBlank
		$I->createEntity("createCategoryWithoutChildrenBlank", "test", "ApiCategoryWithDescription", [], []); // stepKey: createCategoryWithoutChildrenBlank
		$I->createEntity("createCategoryWithChildrenBlank", "test", "ApiCategoryWithChildren", [], []); // stepKey: createCategoryWithChildrenBlank
		$I->createEntity("createFirstCategoryLevelOneBlank", "test", "ApiSubCategoryWithParentLongName", ["createCategoryWithChildrenBlank"], []); // stepKey: createFirstCategoryLevelOneBlank
		$I->createEntity("createSecondCategoryLevelOneBlank", "test", "ApiSubCategoryWithParentLevel1", ["createCategoryWithChildrenBlank"], []); // stepKey: createSecondCategoryLevelOneBlank
		$I->createEntity("createThirdCategoryLevelOneBlank", "test", "ApiSubCategoryWithChildrenLevel1", ["createCategoryWithChildrenBlank"], []); // stepKey: createThirdCategoryLevelOneBlank
		$I->createEntity("createCategoryLevelTwoBlank", "test", "ApiSubCategoryWithChildrenLevel2", ["createThirdCategoryLevelOneBlank"], []); // stepKey: createCategoryLevelTwoBlank
		$I->createEntity("createCategoryLevelThreeBlank", "test", "ApiSubCategoryLevel3", ["createCategoryLevelTwoBlank"], []); // stepKey: createCategoryLevelThreeBlank
		$I->createEntity("createFirstCategoryLevelFourBlank", "test", "ApiSubCategoryLevel4", ["createCategoryLevelThreeBlank"], []); // stepKey: createFirstCategoryLevelFourBlank
		$I->createEntity("createSecondCategoryLevelFourBlank", "test", "ApiSubCategoryLevel4Test", ["createCategoryLevelThreeBlank"], []); // stepKey: createSecondCategoryLevelFourBlank
		$I->createEntity("createCategoryLevelFiveBlank", "test", "ApiSubCategoryLevel5", ["createSecondCategoryLevelFourBlank"], []); // stepKey: createCategoryLevelFiveBlank
		$I->comment("Several rows. Hover on category without children");
		$I->comment("Entering Action Group [reloadPage] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReloadPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReloadPage
		$I->comment("Exiting Action Group [reloadPage] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryWithoutChildrenBlank', 'name', 'test') . "')]]"); // stepKey: hoverCategoryWithoutChildren
		$I->waitForPageLoad(30); // stepKey: hoverCategoryWithoutChildrenWaitForPageLoad
		$I->dontSeeElement("//a[span[contains(., '" . $I->retrieveEntityField('createCategoryWithoutChildrenBlank', 'name', 'test') . "')]]/following-sibling::ul[contains(@class,'level0')]"); // stepKey: dontSeeChildrenInCategory
		$I->comment("Nested level 1. No hover state");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryWithChildrenBlank', 'name', 'test') . "')]]"); // stepKey: hoverCategoryWithChildrenTopLevel
		$I->waitForPageLoad(30); // stepKey: hoverCategoryWithChildrenTopLevelWaitForPageLoad
		$I->comment("Entering Action Group [checkNoHoverState] StorefrontCheckElementColorActionGroup");
		$getElementColorCheckNoHoverState = $I->executeJS("return window.getComputedStyle(document.querySelector('li.level0.parent ul.level0')).getPropertyValue('background-color')"); // stepKey: getElementColorCheckNoHoverState
		$I->assertEquals("rgb(255, 255, 255)", $getElementColorCheckNoHoverState, "pass"); // stepKey: assertElementColorCheckNoHoverState
		$I->comment("Exiting Action Group [checkNoHoverState] StorefrontCheckElementColorActionGroup");
		$I->comment("Nested level 1. Hover state on 1st item");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createFirstCategoryLevelOneBlank', 'name', 'test') . "')]]"); // stepKey: hoverCategoryLevelOneFirstItem
		$I->waitForPageLoad(30); // stepKey: hoverCategoryLevelOneFirstItemWaitForPageLoad
		$I->comment("Entering Action Group [checkHighlightedAfterHoverFirstItem] StorefrontCheckElementColorActionGroup");
		$getElementColorCheckHighlightedAfterHoverFirstItem = $I->executeJS("return window.getComputedStyle(document.querySelector('.level0 .submenu a:hover')).getPropertyValue('background-color')"); // stepKey: getElementColorCheckHighlightedAfterHoverFirstItem
		$I->assertEquals("rgb(232, 232, 232)", $getElementColorCheckHighlightedAfterHoverFirstItem, "pass"); // stepKey: assertElementColorCheckHighlightedAfterHoverFirstItem
		$I->comment("Exiting Action Group [checkHighlightedAfterHoverFirstItem] StorefrontCheckElementColorActionGroup");
		$I->comment("Nested level 1 & 2. Hover state on the last item");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createThirdCategoryLevelOneBlank', 'name', 'test') . "')]]"); // stepKey: hoverCategoryLevelOneLastItem
		$I->waitForPageLoad(30); // stepKey: hoverCategoryLevelOneLastItemWaitForPageLoad
		$I->comment("Entering Action Group [checkHighlightedAfterHoverLastItem] StorefrontCheckElementColorActionGroup");
		$getElementColorCheckHighlightedAfterHoverLastItem = $I->executeJS("return window.getComputedStyle(document.querySelector('.level0 .submenu a:hover')).getPropertyValue('background-color')"); // stepKey: getElementColorCheckHighlightedAfterHoverLastItem
		$I->assertEquals("rgb(232, 232, 232)", $getElementColorCheckHighlightedAfterHoverLastItem, "pass"); // stepKey: assertElementColorCheckHighlightedAfterHoverLastItem
		$I->comment("Exiting Action Group [checkHighlightedAfterHoverLastItem] StorefrontCheckElementColorActionGroup");
		$I->comment("Submenu appears leftward");
		$I->seeElement("ul.level0"); // stepKey: assertTopLevelMenu
		$I->comment("Nested level 1 & 5");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryLevelTwoBlank', 'name', 'test') . "')]]"); // stepKey: hoverCategoryLevelTwo
		$I->waitForPageLoad(30); // stepKey: hoverCategoryLevelTwoWaitForPageLoad
		$I->seeElement("ul.level1"); // stepKey: seeLevelOneMenu
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryLevelThreeBlank', 'name', 'test') . "')]]"); // stepKey: hoverCategoryLevelThree
		$I->waitForPageLoad(30); // stepKey: hoverCategoryLevelThreeWaitForPageLoad
		$I->seeElement("ul.level2"); // stepKey: seeLevelTwoMenu
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createSecondCategoryLevelFourBlank', 'name', 'test') . "')]]"); // stepKey: hoverCategoryLevelFour
		$I->waitForPageLoad(30); // stepKey: hoverCategoryLevelFourWaitForPageLoad
		$I->seeElement("ul.level3"); // stepKey: seeLevelThreeMenu
		$I->comment("Entering Action Group [checkSubcategoryHighlighted] StorefrontCheckElementColorActionGroup");
		$getElementColorCheckSubcategoryHighlighted = $I->executeJS("return window.getComputedStyle(document.querySelector('.level3 .submenu a:hover')).getPropertyValue('background-color')"); // stepKey: getElementColorCheckSubcategoryHighlighted
		$I->assertEquals("rgb(232, 232, 232)", $getElementColorCheckSubcategoryHighlighted, "pass"); // stepKey: assertElementColorCheckSubcategoryHighlighted
		$I->comment("Exiting Action Group [checkSubcategoryHighlighted] StorefrontCheckElementColorActionGroup");
		$I->comment("Delete all creation for Blank theme");
		$I->deleteEntity("createFirstCategoryBlank", "test"); // stepKey: deleteFirstCategoryBlank
		$I->deleteEntity("createSecondCategoryBlank", "test"); // stepKey: deleteSecondCategoryBlank
		$I->deleteEntity("createThirdCategoryBlank", "test"); // stepKey: deleteThirdCategoryBlank
		$I->deleteEntity("createFourthCategoryBlank", "test"); // stepKey: deleteFourthCategoryBlank
		$I->deleteEntity("createFifthCategoryBlank", "test"); // stepKey: deleteFifthCategoryBlank
		$I->deleteEntity("createSixthCategoryBlank", "test"); // stepKey: deleteSixthCategoryBlank
		$I->deleteEntity("createSeventhCategoryBlank", "test"); // stepKey: deleteSeventhCategoryBlank
		$I->deleteEntity("createEighthCategoryBlank", "test"); // stepKey: deleteEighthCategoryBlank
		$I->deleteEntity("createNinthCategoryBlank", "test"); // stepKey: deleteNinthCategoryBlank
		$I->deleteEntity("createTenthCategoryBlank", "test"); // stepKey: deleteTenthCategoryBlank
		$I->deleteEntity("createEleventhCategoryBlank", "test"); // stepKey: deleteEleventhCategoryBlank
		$I->deleteEntity("createTwelfthCategoryBlank", "test"); // stepKey: deleteTwelfthCategoryBlank
		$I->deleteEntity("createThirteenthCategoryBlank", "test"); // stepKey: deleteThirteenthCategoryBlank
		$I->deleteEntity("createCategoryWithChildrenBlank", "test"); // stepKey: deleteCategoryWithChildrenBlank
		$I->deleteEntity("createCategoryWithoutChildrenBlank", "test"); // stepKey: deleteCategoryWithoutChildrenBlank
		$I->comment("Go to Content > Themes. Change theme to Luma");
		$I->comment("Entering Action Group [changeThemeToLuma] AdminChangeStorefrontThemeActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/theme/design_config/"); // stepKey: navigateToDesignConfigPageChangeThemeToLuma
		$I->click("//tr//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)= 'Store View']/preceding-sibling::th)+1][contains(.,'Default Store View')]/..//a[contains(@class, 'action-menu-item')]"); // stepKey: editScopeConfigChangeThemeToLuma
		$I->waitForPageLoad(30); // stepKey: editScopeConfigChangeThemeToLumaWaitForPageLoad
		$I->selectOption("select[name='theme_theme_id']", "Magento Luma"); // stepKey: selectThemeChangeThemeToLuma
		$I->click("#save"); // stepKey: clickSaveChangeThemeToLuma
		$I->waitForPageLoad(30); // stepKey: clickSaveChangeThemeToLumaWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageChangeThemeToLuma
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccessMessageChangeThemeToLuma
		$I->comment("Exiting Action Group [changeThemeToLuma] AdminChangeStorefrontThemeActionGroup");
		$I->comment("Open storefront");
		$I->comment("Entering Action Group [openStorefront] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenStorefront
		$I->comment("Exiting Action Group [openStorefront] StorefrontOpenHomePageActionGroup");
		$I->comment("Create categories");
		$I->createEntity("createFirstCategoryLuma", "test", "ApiCategory", [], []); // stepKey: createFirstCategoryLuma
		$I->createEntity("createSecondCategoryLuma", "test", "ApiCategory", [], []); // stepKey: createSecondCategoryLuma
		$I->createEntity("createThirdCategoryLuma", "test", "ApiCategory", [], []); // stepKey: createThirdCategoryLuma
		$I->createEntity("createFourthCategoryLuma", "test", "ApiCategory", [], []); // stepKey: createFourthCategoryLuma
		$I->comment("Single row. No hover state");
		$I->comment("Entering Action Group [reload] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageReload
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadReload
		$I->comment("Exiting Action Group [reload] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->dontSeeElement("//a[span[contains(., '" . $I->retrieveEntityField('createFirstCategoryLuma', 'name', 'test') . "')]]/following-sibling::ul[contains(@class,'level0')]"); // stepKey: noHoverStateInFirstCategory
		$I->dontSeeElement("//a[span[contains(., '" . $I->retrieveEntityField('createSecondCategoryLuma', 'name', 'test') . "')]]/following-sibling::ul[contains(@class,'level0')]"); // stepKey: noHoverStateInSecondCategory
		$I->dontSeeElement("//a[span[contains(., '" . $I->retrieveEntityField('createThirdCategoryLuma', 'name', 'test') . "')]]/following-sibling::ul[contains(@class,'level0')]"); // stepKey: noHoverStateThirdCategory
		$I->dontSeeElement("//a[span[contains(., '" . $I->retrieveEntityField('createFourthCategoryLuma', 'name', 'test') . "')]]/following-sibling::ul[contains(@class,'level0')]"); // stepKey: noHoverStateInFourthCategory
		$I->comment("Create categories for testing Luma theme");
		$I->createEntity("createFifthCategoryLuma", "test", "ApiCategory", [], []); // stepKey: createFifthCategoryLuma
		$I->createEntity("createCategoryWithChildrenLuma", "test", "ApiCategory", [], []); // stepKey: createCategoryWithChildrenLuma
		$I->createEntity("createFirstCategoryLevelOneLuma", "test", "SubCategoryWithParent", ["createCategoryWithChildrenLuma"], []); // stepKey: createFirstCategoryLevelOneLuma
		$I->createEntity("createSecondCategoryLevelOneLuma", "test", "SubCategoryWithParent", ["createCategoryWithChildrenLuma"], []); // stepKey: createSecondCategoryLevelOneLuma
		$I->createEntity("createThirdCategoryLevelOneLuma", "test", "SubCategoryWithParent", ["createCategoryWithChildrenLuma"], []); // stepKey: createThirdCategoryLevelOneLuma
		$I->createEntity("createFirstCategoryLevelTwoLuma", "test", "SubCategoryWithParent", ["createThirdCategoryLevelOneLuma"], []); // stepKey: createFirstCategoryLevelTwoLuma
		$I->createEntity("createSecondCategoryLevelTwoLuma", "test", "SubCategoryWithParent", ["createThirdCategoryLevelOneLuma"], []); // stepKey: createSecondCategoryLevelTwoLuma
		$I->createEntity("createCategoryLevelThreeLuma", "test", "SubCategoryWithParent", ["createSecondCategoryLevelTwoLuma"], []); // stepKey: createCategoryLevelThreeLuma
		$I->createEntity("createCategoryLevelFourLuma", "test", "SubCategoryWithParent", ["createCategoryLevelThreeLuma"], []); // stepKey: createCategoryLevelFourLuma
		$I->createEntity("createSixthCategoryLuma", "test", "ApiCategory", [], []); // stepKey: createSixthCategoryLuma
		$I->createEntity("createSeventhCategoryLuma", "test", "ApiCategory", [], []); // stepKey: createSeventhCategoryLuma
		$I->createEntity("createEighthCategoryLuma", "test", "ApiCategory", [], []); // stepKey: createEighthCategoryLuma
		$I->comment("Several rows. Hover on Category without children");
		$I->comment("Entering Action Group [refresh] ReloadPageActionGroup");
		$I->reloadPage(); // stepKey: reloadPageRefresh
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadRefresh
		$I->comment("Exiting Action Group [refresh] ReloadPageActionGroup");
		$I->comment("Replacing reload action and preserve Backward Compatibility");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createFifthCategoryLuma', 'name', 'test') . "')]]"); // stepKey: hoverOnCategoryWithoutChildren
		$I->waitForPageLoad(30); // stepKey: hoverOnCategoryWithoutChildrenWaitForPageLoad
		$I->dontSeeElement("//a[span[contains(., '" . $I->retrieveEntityField('createFifthCategoryLuma', 'name', 'test') . "')]]/following-sibling::ul[contains(@class,'level0')]"); // stepKey: dontSeeSubcategoriesInCategory
		$I->comment("Nested level 1. No hover state");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryWithChildrenLuma', 'name', 'test') . "')]]"); // stepKey: hoverOnCategoryWithChildren
		$I->waitForPageLoad(30); // stepKey: hoverOnCategoryWithChildrenWaitForPageLoad
		$I->comment("Entering Action Group [checkNoHighlightedInSubmenuAfterHover] StorefrontCheckElementColorActionGroup");
		$getElementColorCheckNoHighlightedInSubmenuAfterHover = $I->executeJS("return window.getComputedStyle(document.querySelector('li.level0.parent ul.level0')).getPropertyValue('background-color')"); // stepKey: getElementColorCheckNoHighlightedInSubmenuAfterHover
		$I->assertEquals("rgb(255, 255, 255)", $getElementColorCheckNoHighlightedInSubmenuAfterHover, "pass"); // stepKey: assertElementColorCheckNoHighlightedInSubmenuAfterHover
		$I->comment("Exiting Action Group [checkNoHighlightedInSubmenuAfterHover] StorefrontCheckElementColorActionGroup");
		$I->comment("Nested level 1. Hover state on first item");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createFirstCategoryLevelOneLuma', 'name', 'test') . "')]]"); // stepKey: hoverOnFirstItemLevelOne
		$I->waitForPageLoad(30); // stepKey: hoverOnFirstItemLevelOneWaitForPageLoad
		$I->comment("Entering Action Group [checkHighlightedAfterHoverOnFirstItem] StorefrontCheckElementColorActionGroup");
		$getElementColorCheckHighlightedAfterHoverOnFirstItem = $I->executeJS("return window.getComputedStyle(document.querySelector('.level0 .submenu a:hover')).getPropertyValue('background-color')"); // stepKey: getElementColorCheckHighlightedAfterHoverOnFirstItem
		$I->assertEquals("rgb(232, 232, 232)", $getElementColorCheckHighlightedAfterHoverOnFirstItem, "pass"); // stepKey: assertElementColorCheckHighlightedAfterHoverOnFirstItem
		$I->comment("Exiting Action Group [checkHighlightedAfterHoverOnFirstItem] StorefrontCheckElementColorActionGroup");
		$I->comment("Nested levels 1 & 2. Hover state on last item");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createThirdCategoryLevelOneLuma', 'name', 'test') . "')]]"); // stepKey: hoverOnLastItemLevelOne
		$I->waitForPageLoad(30); // stepKey: hoverOnLastItemLevelOneWaitForPageLoad
		$I->comment("Entering Action Group [checkHighlightedAfterHoverOnLastItem] StorefrontCheckElementColorActionGroup");
		$getElementColorCheckHighlightedAfterHoverOnLastItem = $I->executeJS("return window.getComputedStyle(document.querySelector('.level0 .submenu a:hover')).getPropertyValue('background-color')"); // stepKey: getElementColorCheckHighlightedAfterHoverOnLastItem
		$I->assertEquals("rgb(232, 232, 232)", $getElementColorCheckHighlightedAfterHoverOnLastItem, "pass"); // stepKey: assertElementColorCheckHighlightedAfterHoverOnLastItem
		$I->comment("Exiting Action Group [checkHighlightedAfterHoverOnLastItem] StorefrontCheckElementColorActionGroup");
		$I->comment("Submenu appears rightward");
		$I->seeElement("ul.level0"); // stepKey: seeTopLevel
		$I->comment("Nested levels 1 & 5");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createSecondCategoryLevelTwoLuma', 'name', 'test') . "')]]"); // stepKey: hoverThirdCategoryLevelTwo
		$I->waitForPageLoad(30); // stepKey: hoverThirdCategoryLevelTwoWaitForPageLoad
		$I->seeElement("ul.level1"); // stepKey: seeFirstLevelMenu
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryLevelThreeLuma', 'name', 'test') . "')]]"); // stepKey: hoverOnCategoryLevelThree
		$I->waitForPageLoad(30); // stepKey: hoverOnCategoryLevelThreeWaitForPageLoad
		$I->seeElement("ul.level2"); // stepKey: seeSecondLevelMenu
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryLevelFourLuma', 'name', 'test') . "')]]"); // stepKey: hoverOnCategoryLevelFour
		$I->waitForPageLoad(30); // stepKey: hoverOnCategoryLevelFourWaitForPageLoad
		$I->seeElement("ul.level3"); // stepKey: seeThirdLevelMenu
		$I->comment("Entering Action Group [checkSubcategoryHighlightedAfterHover] StorefrontCheckElementColorActionGroup");
		$getElementColorCheckSubcategoryHighlightedAfterHover = $I->executeJS("return window.getComputedStyle(document.querySelector('.level3 .submenu a:hover')).getPropertyValue('background-color')"); // stepKey: getElementColorCheckSubcategoryHighlightedAfterHover
		$I->assertEquals("rgb(232, 232, 232)", $getElementColorCheckSubcategoryHighlightedAfterHover, "pass"); // stepKey: assertElementColorCheckSubcategoryHighlightedAfterHover
		$I->comment("Exiting Action Group [checkSubcategoryHighlightedAfterHover] StorefrontCheckElementColorActionGroup");
		$I->comment("Selected 1st level category");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryWithChildrenLuma', 'name', 'test') . "')]]"); // stepKey: openTopLevelCategory
		$I->waitForPageLoad(30); // stepKey: openTopLevelCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoaded
		$I->comment("Assert category active state");
		$I->comment("Entering Action Group [checkCategoryActiveState] StorefrontCheckElementColorActionGroup");
		$getElementColorCheckCategoryActiveState = $I->executeJS("return window.getComputedStyle(document.querySelector('.navigation .level0.active>.level-top')).getPropertyValue('border-color')"); // stepKey: getElementColorCheckCategoryActiveState
		$I->assertEquals("rgb(255, 85, 1)", $getElementColorCheckCategoryActiveState, "pass"); // stepKey: assertElementColorCheckCategoryActiveState
		$I->comment("Exiting Action Group [checkCategoryActiveState] StorefrontCheckElementColorActionGroup");
		$I->comment("Selected subcategory. Assert active state");
		$I->comment("Entering Action Group [openSubcategory] StorefrontGoToSubCategoryPageActionGroup");
		$I->amOnPage("/"); // stepKey: onFrontendOpenSubcategory
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenSubcategory
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryWithChildrenLuma', 'name', 'test') . "')]]"); // stepKey: toCategoryOpenSubcategory
		$I->waitForPageLoad(30); // stepKey: toCategoryOpenSubcategoryWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createThirdCategoryLevelOneLuma', 'name', 'test') . "')]]"); // stepKey: openSubCategoryOpenSubcategory
		$I->waitForPageLoad(30); // stepKey: openSubCategoryOpenSubcategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageOpenSubcategory
		$I->comment("Exiting Action Group [openSubcategory] StorefrontGoToSubCategoryPageActionGroup");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryWithChildrenLuma', 'name', 'test') . "')]]"); // stepKey: hoverOnCategory
		$I->waitForPageLoad(30); // stepKey: hoverOnCategoryWaitForPageLoad
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createThirdCategoryLevelOneLuma', 'name', 'test') . "')]]"); // stepKey: hoverOnSubcategory
		$I->waitForPageLoad(30); // stepKey: hoverOnSubcategoryWaitForPageLoad
		$I->comment("Assert subcategory active state");
		$I->comment("Entering Action Group [checkSubitemActiveState] StorefrontCheckElementColorActionGroup");
		$getElementColorCheckSubitemActiveState = $I->executeJS("return window.getComputedStyle(document.querySelector('.navigation .level0 .submenu .active>a')).getPropertyValue('border-color')"); // stepKey: getElementColorCheckSubitemActiveState
		$I->assertEquals("rgb(255, 85, 1)", $getElementColorCheckSubitemActiveState, "pass"); // stepKey: assertElementColorCheckSubitemActiveState
		$I->comment("Exiting Action Group [checkSubitemActiveState] StorefrontCheckElementColorActionGroup");
		$I->comment("Delete created category");
		$I->deleteEntity("createFirstCategoryLuma", "test"); // stepKey: deleteFirstCategoryLuma
		$I->deleteEntity("createSecondCategoryLuma", "test"); // stepKey: deleteSecondCategoryLuma
		$I->deleteEntity("createThirdCategoryLuma", "test"); // stepKey: deleteThirdCategoryLuma
		$I->deleteEntity("createFourthCategoryLuma", "test"); // stepKey: deleteFourthCategoryLuma
		$I->deleteEntity("createFifthCategoryLuma", "test"); // stepKey: deleteFifthCategoryLuma
		$I->deleteEntity("createSixthCategoryLuma", "test"); // stepKey: deleteSixthCategoryLuma
		$I->deleteEntity("createSeventhCategoryLuma", "test"); // stepKey: deleteSeventhCategoryLuma
		$I->deleteEntity("createEighthCategoryLuma", "test"); // stepKey: deleteEighthCategoryLuma
		$I->deleteEntity("createCategoryWithChildrenLuma", "test"); // stepKey: deleteCategoryWithChildrenLuma
	}
}
