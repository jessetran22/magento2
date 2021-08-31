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
 * @Title("MAGETWO-98934: DEPRECATED. Admin should see Google chart on Magento dashboard")
 * @Description("Google chart on Magento dashboard page is displaying properly<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use AdminCheckDashboardWithChartsTest instead</li></ul><h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/AdminDashboardWithChartsTest.xml<br>")
 * @TestCaseId("MAGETWO-98934")
 * @group backend
 */
class AdminDashboardWithChartsTestCest
{
	/**
	 * @Features({"Backend"})
	 * @Stories({"Google Charts on Magento dashboard"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDashboardWithChartsTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse AdminCheckDashboardWithChartsTest instead");
	}
}
