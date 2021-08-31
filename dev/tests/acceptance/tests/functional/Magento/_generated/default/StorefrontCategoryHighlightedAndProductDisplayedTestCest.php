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
 * @Title("MC-19626: Сheck that current category is highlighted and all products displayed for it")
 * @Description("Сheck that current category is highlighted and all products displayed for it<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/StorefrontCategoryHighlightedAndProductDisplayedTest.xml<br>")
 * @TestCaseId("MC-19626")
 * @group Catalog
 */
class StorefrontCategoryHighlightedAndProductDisplayedTestCest
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
		$I->createEntity("category1", "hook", "SimpleSubCategory", [], []); // stepKey: category1
		$I->createEntity("category2", "hook", "SimpleSubCategory", [], []); // stepKey: category2
		$I->createEntity("category3", "hook", "SimpleSubCategory", [], []); // stepKey: category3
		$I->createEntity("category4", "hook", "SimpleSubCategory", [], []); // stepKey: category4
		$I->createEntity("product1", "hook", "SimpleProduct", ["category1"], []); // stepKey: product1
		$I->createEntity("product2", "hook", "SimpleProduct", ["category1"], []); // stepKey: product2
		$I->createEntity("product3", "hook", "SimpleProduct", ["category2"], []); // stepKey: product3
		$I->createEntity("product4", "hook", "SimpleProduct", ["category2"], []); // stepKey: product4
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("product1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("product2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("product3", "hook"); // stepKey: deleteProduct3
		$I->deleteEntity("product4", "hook"); // stepKey: deleteProduct4
		$I->deleteEntity("category1", "hook"); // stepKey: deleteCategory1
		$I->deleteEntity("category2", "hook"); // stepKey: deleteCategory2
		$I->deleteEntity("category3", "hook"); // stepKey: deleteCategory3
		$I->deleteEntity("category4", "hook"); // stepKey: deleteCategory4
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
	 * @Stories({"Category"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCategoryHighlightedAndProductDisplayedTest(AcceptanceTester $I)
	{
		$I->comment("Open Storefront home page");
		$I->comment("Open Storefront home page");
		$I->comment("Entering Action Group [goToStorefrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefrontHomePage
		$I->comment("Exiting Action Group [goToStorefrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Click on first category");
		$I->comment("Click on first category");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('category1', 'name', 'test') . "')]"); // stepKey: clickCategory1Name
		$I->waitForPageLoad(30); // stepKey: clickCategory1NameWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategory1Page
		$I->comment("Check if current category is highlighted and the others are not");
		$I->comment("Check if current category is highlighted and the others are not");
		$grabCategory1Class = $I->grabAttributeFrom("//div[@id='store.menu']//span[contains(text(),'" . $I->retrieveEntityField('category1', 'name', 'test') . "')]/ancestor::li", "class"); // stepKey: grabCategory1Class
		$I->waitForPageLoad(30); // stepKey: grabCategory1ClassWaitForPageLoad
		$I->assertStringContainsString("active", $grabCategory1Class); // stepKey: assertCategory1IsHighlighted
		$highlightedAmount = $I->executeJS("return document.querySelectorAll('[id=\'store.menu\'] ul li.active').length"); // stepKey: highlightedAmount
		$I->waitForPageLoad(30); // stepKey: highlightedAmountWaitForPageLoad
		$I->assertEquals(1, $highlightedAmount); // stepKey: assertRestCategories1IsNotHighlighted
		$I->comment("See products in the category page");
		$I->comment("See products in the category page");
		$I->seeElement("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('product1', 'name', 'test') . "')]"); // stepKey: seeProduct1InCategoryPage
		$I->seeElement("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('product2', 'name', 'test') . "')]"); // stepKey: seeProduct2InCategoryPage
		$I->comment("Click on second category");
		$I->comment("Click on second category");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('category2', 'name', 'test') . "')]"); // stepKey: clickCategory2Name
		$I->waitForPageLoad(30); // stepKey: clickCategory2NameWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategory2Page
		$I->comment("Check if current category is highlighted  and the others are not");
		$I->comment("Check if current category is highlighted and the others are not");
		$grabCategory2Class = $I->grabAttributeFrom("//div[@id='store.menu']//span[contains(text(),'" . $I->retrieveEntityField('category2', 'name', 'test') . "')]/ancestor::li", "class"); // stepKey: grabCategory2Class
		$I->waitForPageLoad(30); // stepKey: grabCategory2ClassWaitForPageLoad
		$I->assertStringContainsString("active", $grabCategory2Class); // stepKey: assertCategory2IsHighlighted
		$highlightedAmount2 = $I->executeJS("return document.querySelectorAll('[id=\'store.menu\'] ul li.active').length"); // stepKey: highlightedAmount2
		$I->waitForPageLoad(30); // stepKey: highlightedAmount2WaitForPageLoad
		$I->assertEquals(1, $highlightedAmount2); // stepKey: assertRestCategories1IsNotHighlighted2
		$I->comment("Assert products in second category page");
		$I->comment("Assert products in second category page");
		$I->seeElement("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('product3', 'name', 'test') . "')]"); // stepKey: seeProduct3InCategoryPage
		$I->seeElement("//a[@class='product-item-link'][contains(text(), '" . $I->retrieveEntityField('product4', 'name', 'test') . "')]"); // stepKey: seeProduct4InCategoryPage
	}
}
