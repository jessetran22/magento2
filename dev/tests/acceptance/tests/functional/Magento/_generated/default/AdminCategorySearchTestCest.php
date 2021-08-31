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
 * @Title("MC-37809: Search for categories")
 * @Description("Global search in backend can search into Categories.<h3>Test files</h3>app/code/Magento/CatalogSearch/Test/Mftf/Test/AdminCategorySearchTest.xml<br>")
 * @group Search
 * @TestCaseId("MC-37809")
 */
class AdminCategorySearchTestCest
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
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
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
		$I->comment("Create Simple Category");
		$I->createEntity("createSimpleCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createSimpleCategory
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created category");
		$I->deleteEntity("createSimpleCategory", "hook"); // stepKey: deleteCreatedCategory
		$I->comment("Log out");
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
	 * @Features({"CatalogSearch"})
	 * @Stories({"Search categories in admin panel"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCategorySearchTest(AcceptanceTester $I)
	{
		$I->comment("Add created category name in the search field");
		$I->comment("Entering Action Group [setSearch] AdminSetGlobalSearchValueActionGroup");
		$I->click(".search-global-label"); // stepKey: clickSearchBtnSetSearch
		$I->waitForElementVisible(".search-global-field._active", 30); // stepKey: waitForSearchInputVisibleSetSearch
		$I->fillField(".search-global-input", $I->retrieveEntityField('createSimpleCategory', 'name', 'test')); // stepKey: fillSearchSetSearch
		$I->comment("Exiting Action Group [setSearch] AdminSetGlobalSearchValueActionGroup");
		$I->comment("Wait for suggested results");
		$I->waitForElementVisible("//span[contains(text(), 'Category')]", 30); // stepKey: waitForSuggestions
		$I->comment("Click on suggested result in category URL");
		$I->click("//span[contains(text(), 'Category')]/preceding-sibling::a"); // stepKey: openCategory
		$I->comment("Wait for suggested results");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Loaded page should be edit page of created category");
		$I->seeInField("input[name='name']", $I->retrieveEntityField('createSimpleCategory', 'name', 'test')); // stepKey: checkCategoryName
	}
}
